<form action="/api/find-bus" method="post">
    <div>
        <label>
            From
            <input type="text" name="destination[from]" value="<?= htmlspecialchars($destination['from']); ?>">
        </label>
        <label>
            To
            <input type="text" name="destination[to]" value="<?= htmlspecialchars($destination['to']); ?>">
        </label>
    </div>
    <input type="submit" value="Find">
</form>