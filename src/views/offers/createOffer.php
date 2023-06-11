<form action="/offers" method="POST">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" placeholder="Title" required>
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Description" required></textarea>
    <select name="category" id="category">
        <option value="0">Select category</option>
        <?php foreach (Category::cases() as $category) {
            echo "<option value='{$category->value}'>{$category->value}</option>";
        }
        ?>
    </select>
    <label for="requirements">Requirements</label>
    <textarea name="requirements" id="requirements" cols="30" rows="10" placeholder="Requirements" required></textarea>
    <label for="location">Location</label>
    <input type="text" name="location" id="location" placeholder="Location" required>
    <label for="salaryLower">Salary lower</label>
    <input type="number" name="salaryLower" id="salaryLower" placeholder="Salary lower" required>
    <label for="salaryUpper">Salary upper</label>
    <input type="number" name="salaryUpper" id="salaryUpper" placeholder="Salary upper" required>
    <input type="submit" name="submit" value="Create Offer">
</form>