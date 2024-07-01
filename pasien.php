<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Data Pasien</title>
    <link rel="icon" href="title_icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #3366ff;
            color: white;
            padding: 15px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .sidebar h2 {
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 3px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #007B5F;
        }

        .content {
            flex: 1;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .content h2 {
            margin-top: 0;
        }

        .search-suggestion {
            position: absolute;
            background-color: white;
            border: 1px solid #ddd;
            z-index: 999;
            max-height: 200px;
            overflow-y: auto;
            width: calc(100% - 22px);
            display: none;
        }

        .search-suggestion a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .search-suggestion a:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <div class="container">
            <br>
            <h2>PASIEN</h2>
            <h4>Data Pasien</h4>



            <form class="form-inline mb-3" method="GET" action="">
                <input class="form-control mr-sm-2" type="search" id="search" name="search" placeholder="Cari Nama Pasien" aria-label="Search" value="">
                <div class="search-suggestion"></div>
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="searchData()">Search</button>
                <a href="pasien.php" class="btn btn-outline-secondary my-2 my-sm-0 ml-2"><img src="images/refresh.png" alt="Refresh"></a>
                <a href="create_pasien.php" class="btn btn-primary ml-auto">Tambah Data</a>
            </form>

            <div id="data-pasien"></div>
            <nav aria-label="Page navigation">
                <ul class="pagination" id="pagination">
                </ul>
            </nav>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#search').keyup(function() {
                var query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: 'fetch_suggestions.php',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            $('.search-suggestion').html(response).fadeIn();
                        }
                    });
                } else {
                    $('.search-suggestion').fadeOut();
                }
            });

            $(document).on('click', '.search-suggestion a', function(e) {
                e.preventDefault();
                var suggestion = $(this).text();
                $('#search').val(suggestion);
                $('.search-suggestion').fadeOut();
            });

            loadData(1);
        });

        function loadData(page, search = '') {
            $.ajax({
                url: 'fetch_data.php',
                type: 'GET',
                data: {
                    page: page,
                    search: search
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    $('#data-pasien').html(result.data);
                    $('#pagination').html(result.pagination);
                }
            });
        }

        function searchData() {
            var search = $('#search').val();
            loadData(1, search);
        }

        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page-number');
            var search = $('#search').val();
            loadData(page, search);
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var confirmation = confirm("Apakah Anda yakin ingin menghapus data ini?");

            if (confirmation) {
                $.ajax({
                    url: 'delete_pasien.php',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            alert(result.message);
                            loadData(1);
                        } else {
                            alert(result.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            }
        });
        $(document).on('click', '.btn-update', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            window.location.href = 'update_pasien.php?id=' +
                id;
        });
    </script>
</body>

</html>