document.addEventListener('DOMContentLoaded', function () {
    let offset = 24;
    document.getElementById('loadMore').addEventListener('click', function () {
        fetch('load_more.php?gender=' + gender + '&offset=' + offset)
            .then(response => response.text())
            .then(data => {
                document.getElementById('productContainer').innerHTML += data;
                offset += 24;
            });
    });
});
