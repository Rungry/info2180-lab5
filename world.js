window.onload = function () {
    // Get elements from the page
    let lookupBtn = document.getElementById("lookup");
    let lookupCitiesBtn = document.getElementById("lookup-cities");
    let countryInput = document.getElementById("country");
    let resultDiv = document.getElementById("result");

    // Country Lookup
    lookupBtn.addEventListener("click", function () {
        let country = countryInput.value.trim();

        // Build request URL
        let url = "world.php?country=" + encodeURIComponent(country);

        // Make AJAX request using fetch()
        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;   // Display the HTML from PHP
            })
            .catch(error => {
                resultDiv.innerHTML = "<p style='color:red;'>Error fetching data</p>";
                console.error(error);
            });
    });

    //City Lookup
    lookupCitiesBtn.addEventListener("click", function () {
        let country = countryInput.value.trim();
        let url = "world.php?country=" + encodeURIComponent(country) + "&lookup=cities";

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                resultDiv.innerHTML = "<p style='color:red;'>Error fetching cities</p>";
                console.error(error);
            });
    });

};