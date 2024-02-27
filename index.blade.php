<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Fetch On Scrolling</title>
</head>
<body>
    <div id="infiniteScrollingList"> </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const infiniteScrollingList = document.getElementById('infiniteScrollingList');
            let sl = 1;
            let count = 1;
            let maxCount = count;
            let fetch_flag = true; // Flag to track whether data fetching is in progress

            function fetchAndDisplayRows() {
                if (fetch_flag) {
                    fetch_flag = false; // Set flag to indicate data fetching is in progress
                    fetch(`{{ route('load_data') }}?count=${count}`)
                        .then(response => response.json())
                        .then(data => {
                            const infinite_data = data.infinite_data;
                            maxCount = data.max_count;

                            infinite_data.forEach(row => {
                                const rowElement = document.createElement('div');
                                rowElement.textContent = `${sl}. ${row.first_name} ${row.last_name}, Age: ${row.age}, ID: ${row.id}`;
                                infiniteScrollingList.appendChild(rowElement);
                                sl++;
                            });
                            fetch_flag = true; // Reset flag after data is fetched
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                            fetch_flag = true; // Reset flag on error
                        });
                    count++;
                }
            }

            fetchAndDisplayRows();

            window.addEventListener('scroll', function () {
                if (window.innerHeight + window.scrollY >= document.body.offsetHeight / 1.3 && maxCount >= count) {
                    fetchAndDisplayRows();
                }
            });
        });

    </script>
</body>
</html>
