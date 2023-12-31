<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DropDown Employee </title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <form action="" style="margin: 1em 1em 4em 21em; font-size:28px;" method="POST">
    <label for="state">Select State:</label>
    <select id="state" name="state" style="font-size: 18px;" onchange="getCities()">
        <option value="">Select State</option>
        <?php
            // Fetch states from the database
            // require "connection.php";

            $result = $conn->query("SELECT * FROM states");

            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['state_name']}</option>";
            }

            // $conn->close();
        ?>
    </select>

    <label for="city">Select City:</label>
    <select id="city" name="city" style="font-size: 18px;">
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

    <input type="submit" value="Show Selected Emp" style="font-size: 14px;">

</form>
</body>
</html>
