<form action="/users" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo $_GET['email'] ?>" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" value="<?php echo $_GET['password'] ?>" required>
    <label for="userType">User type:</label>
    <input type="hidden" name="userType" id="userType" value="<?php echo UserType::CANDIDATE->value ?>" required>
    <div class="switch">
        <label>
            Candidate
            <input type="checkbox" id="userTypeSwitch" name="userType">
            <span class="lever"></span>
            Company
        </label>
    </div>
    <br>
    <div id='userTypeFields'>
        <label for="firstName">First name:</label>
        <input type="text" name="firstName" id="firstName" required>
        <label for="lastName">Last name:</label>
        <input type="text" name="lastName" id="lastName" required>
    </div>
    <input type="submit" name="submit" value="Register">
</form>

<?php
if (isset($_POST)) {
    $_POST['origin'] = Origin::LOCAL->value;
}
?>
<script>
    const userTypeFields = document.getElementById('userTypeFields');
    const userType = document.getElementById('userTypeSwitch');
    const userTypeValue = document.getElementById('userType');
    userType.addEventListener('click', () => {
        if (userType.checked) {
            userTypeValue.value = "<?php echo UserType::COMPANY->value ?>";
            userTypeFields.innerHTML = `
            <label for="companyName">Company name:</label>
            <input type="text" name="companyName" id="companyName" required>
            <label for="location">Location:</label>
            <input type="text" name="location" id="location" required>
            <label for="description">Description:</label>
                    <input type="text" name="description" id="description" required>
                    `;
        } else {
            userTypeValue.value = "<?php echo UserType::CANDIDATE->value ?>";
            userTypeFields.innerHTML = `
                    <label for="firstName">First name:</label>
                    <input type="text" name="firstName" id="firstName" required>
                    <label for="lastName">Last name:</label>
                    <input type="text" name="lastName" id="lastName" required>
                    `;
        }
        console.log(userTypeValue.value)
    });
</script>