<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use DOMDocument;
use DOMXPath;

//MODELS
use App\Models\Online;
use App\Models\Income;

class ParserService
{
    //classes stat for db
    private $arrayStat = [
        'online' => Online::class,
        'income' => Income::class,
    ];

    //run parser
    public function runParser($parser) {
        $parserArray = [
            'zzz-activeplayerio' => 'zzzActivePlayerIo'
        ];

        $nameFunc = $parserArray[$parser];
        //start parsing and get result
        $result = $this->$nameFunc();

        //send result
        return $result;
    }

    //load raw json to db
    public function loadJsonRaw($validated) {
        //NAME is value from SELECT of form + .json
        $jsonFileName = $validated['json-raw'] . '.json';

        //get file if exist
        if(Storage::exists("parser/results/{$jsonFileName}")) {
            $file = Storage::json("parser/results/$jsonFileName");

            //make array with full vars for db
            $result_array = $this->makeFinalArray($file, $validated['id'], $validated['source']);

            $dateFrom = $validated['date-from'];
            $dateTo = $validated['date-to'];

            //take records depends on date
            $result_array = array_filter($result_array, function($record) use ($dateFrom, $dateTo) {
                    $record_month = substr($record['date'], 0, 7); //get XXXX-XX format
                    return $record_month >= $dateFrom
                        &&  $record_month <= $dateTo;
                });

            //take model depends on stat
            $model = $this->arrayStat[$validated['stat']];

            //add or update existed
            $db_records = $model::upsert($result_array, ['game_id', 'date', 'source'], ['stat']);
            
            return "Were added $db_records records.";
        } else {
            return 'File not exist';
        }
    }

    //main logic of zzzActivePlayerIo parser
    protected function zzzActivePlayerIo() {
        $url = 'https://activeplayer.io/zenless-zone-zero/';

        //get $xpath 
        $xpath = $this->parseUrl($url);
        if($xpath === null) return 'Problem with parser. Check logFile';

        //get online from parsed page
        $table = $xpath->query("//table[contains(@class, 'asdrm-monthly-stats-table')]/tbody//tr");

        //make assoc array to join apple/android stat
        $dates_stat = [];

        //get from parser date and online
        foreach($table as $tr) {
            //get td for current tr
            $tdMonthYear = $xpath->query("td", $tr)->item(0)->textContent;
            $tdStat = $xpath->query("td", $tr)->item(1)->textContent;
            
            //call function to make good view
            $date = $this->lineMonthYearToDate($tdMonthYear);
            $stat = $this->lineStatToFloat($tdStat);

            $dates_stat[$date] = round(($dates_stat[$date] ?? 0.0) + $stat, 1);
        }

        if(!is_array($dates_stat) || count($dates_stat) === 0) return "Array from parser is empty.";

        //save as json
        $this->saveAsJson($dates_stat, 'zzz-activeplayerio');

        //answer that is done
        return 'Parser for ZZZ online from activeplayer.io is done.';
    }

    //COMMON FUNC FOR PARSER OPERATION
    private function parseUrl($url) {
        libxml_use_internal_errors(true);  //html warning in buffer
    
        $html = $this->fetch($url);

        //if curl error -> fetch return null => exit for next url
        if(!$html) return null;

        $dom = new DOMDocument();
        $dom->loadHTML($html);

        libxml_clear_errors(); //clean buffer with html warnings

        $xpath = new DOMXPath($dom);

        return $xpath;
    }

    //url parsing main logic
    private function fetch($url) {
        $ch = curl_init($url);

        $cookiePathSave = storage_path('app/private/parser/cookies.txt');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIEJAR => $cookiePathSave,
            CURLOPT_COOKIEFILE => $cookiePathSave,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
                "Accept: text/html",
                "Accept-Language: en-US,en;q=0.9",
            ]
        ]);

        $html = curl_exec($ch);
        $errNumber = curl_errno($ch);
        $errMsg = curl_error($ch);
        $curlDetails = curl_getinfo($ch);
        curl_close($ch);

        //if has any curl error
        if($errNumber) {
            $this->logParse('ERROR', 'Curl failed', ['url' => $url, 'errNumber' => $errNumber, $errMsg => $errMsg]);

            return null;
        }

        //if has http error
        $httpCode = $curlDetails['http_code'] ?? 0;
        if($httpCode >= 400) {
            $this->logParse('Warning', 'Http error', ['url' => $url, 'code' => $httpCode]);

            return null;
        }

        //delay
        usleep(rand(500000, 1500000)); // 0.5 - 1.5 sec

        //write result of curl in parser.log 
        $this->logParse('OK', 'Curl is ok', ['url' => $url, 'details' => $curlDetails]);

        return $html;
    }

    //log function
    private function logParse($tag, $msg, $array = []) {
        $time = date('Y-m-d H:i:s');
        $arrayToStr = $array ? ' ' . json_encode($array, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) : '';
        $str = "[$time] [$tag] $msg $arrayToStr" . PHP_EOL;

        //write to file
        Storage::disk('local')->append('parser/logs/parser.log', $str);
    }

    //function to make from line "Month year" -> "xxxx-xx-01"
    private function lineMonthYearToDate($dateLine) {
        $month_array = [
            'january' => '01',
            'february' => '02',
            'march' => '03',
            'april' => '04',
            'may' => '05',
            'june' => '06',
            'july' => '07',
            'august' => '08',
            'september' => '09',
            'october' => '10',
            'november' => '11',
            'december' => '12'
        ];

        //separate line to array
        $line_to_array = explode(" ", strtolower($dateLine));

        //global vars for month and year
        $month = null;
        $year = null;

        foreach($line_to_array as $line) {
            if(preg_match('/^[0-9]{4}$/', $line)) $year = $line; 
            if(array_key_exists(trim($line), $month_array)) $month = $month_array[$line];
        }

        if($month === null || $year === null) return false;

        $date_line = "$year-$month-01";
        return $date_line;
    }

    //func to make stat from string to float: '451.3k' -> '451.3'
    private function lineStatToFloat($line) {
        $stat = (float)$line;
        return $stat;
    }

    //make from array['date'=>'stat'] -> final array with key: id_game, date, stat, source
    private function makeFinalArray($array_date_stat, $id_game, $source) {
        $final_array = [];
        
        foreach($array_date_stat as $date => $stat) {
            $final_array[] = [
                'game_id' => $id_game,
                'date' => $date,
                'stat' => strtolower($stat),
                'source' => $source
            ];
        }

        return $final_array;
    }

    //save result as json file
    private function saveAsJson($array, $file_name) {
        $file_name = $file_name . '.json';
        
        //save json file
        Storage::disk('local')->put("parser/results/$file_name", json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
