<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Dropdown</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <label for="state">Select State:</label>
    <select id="state" name="state" onchange="getCities()">
        <option value="">Select State</option>
        <?php
            // Fetch states from the database
            $conn = new mysqli("localhost", "root", "password", "rohit");

            $result = $conn->query("SELECT * FROM states");

            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['state_name']}</option>";
            }

            $conn->close();
        ?>
    </select>

    <label for="city">Select City:</label>
    <select id="city" name="city">
        <option value="">Select City</option>
    </select>

    <script>
        function getCities() {
            var stateId = document.getElementById("state").value;

            $.ajax({
                type: "POST",
                url: "get_cities2.php",
                data: { state_id: stateId },
                success: function (response) {
                    $("#city").html(response);
                }
            });
        }
    </script>
</body>
</html>
