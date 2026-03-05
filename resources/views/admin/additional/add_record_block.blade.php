<label>
            <b>Game ID:</b>
            <input type="number" name="id" minlength="1" maxlength="10" placeholder="Put game id" required/>
        </label>
        <label>
            <b>Month and year:</b>
            <input type="month" name="date" required/>
        </label>
        <label>
            <b>Number:</b>
            <input type="number" name="stat_number" minlength="1" maxlength="10" placeholder="Put n param" required/>
        </label>
        <label>
            <b>Source(<small>!Month can't have 2+ same sources):</small></b>
            <input type="text" name="source" minlength="3" maxlength="128" placeholder="Put param source" required/>
        </label>
        <button type="submit" class="admin-btn">Add game's record</button>