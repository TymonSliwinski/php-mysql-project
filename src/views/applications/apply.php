<form action="/applications" method="POST">
    <label for="description">Description</label>
    <input type="text" name="description" id="description" placeholder="Description" required>
    <input type="hidden" name="offerId" value="<?php echo $_GET['offerId'] ?>">
    <input type="submit" name="submit" value="Apply">
</form>