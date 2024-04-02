<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Client</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="getAllCategories()">
    <a href="./Consumir.php">Volver</a>
    <button onclick="getCategoryById()">Obtener categoría por ID</button>
    <button onclick="insertCategory()">Insertar categoría</button>
    <table id="categoriesTable" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Observación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="categoriesBody">
            <!-- Aquí se mostrarán las categorías -->
        </tbody>
    </table>
    <div id="response" style="margin-top: 20px;"></div>

    <script>
        function displayCategories(categories) {
            var categoriesBody = $('#categoriesBody');
            categoriesBody.empty();

            categories.forEach(function(category) {
                var row = '<tr>' +
                            '<td>' + category.cat_id + '</td>' +
                            '<td>' + category.cat_nom + '</td>' +
                            '<td>' + category.cat_obs + '</td>' +
                            '<td>' +
                                '<button onclick="updateCategory(' + category.cat_id + ')">Actualizar</button>' +
                                '<button onclick="deleteCategory(' + category.cat_id + ')">Eliminar</button>' +
                            '</td>' +
                          '</tr>';
                categoriesBody.append(row);
            });
        }

        function getAllCategories() {
            $.ajax({
                url: 'controller/categoria.php?op=GetAll',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    displayCategories(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function getCategoryById() {
            var catId = prompt('Ingrese el ID de la categoría:');
            $.ajax({
                url: './controller/categoria.php?op=GetId',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ cat_id: catId }),
                dataType: 'json',
                success: function(data) {
                    displayCategories(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function insertCategory() {
            var catNom = prompt('Ingrese el nombre de la categoría:');
            var catObs = prompt('Ingrese la observación de la categoría:');
            $.ajax({
                url: './controller/categoria.php?op=Insert',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ cat_nom: catNom, cat_obs: catObs }),
                dataType: 'json',
                success: function(data) {
                    displayResponse(data.alert);
                    getAllCategories(); 
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function updateCategory(catId) {
            var catNom = prompt('Ingrese el nuevo nombre de la categoría:');
            var catObs = prompt('Ingrese la nueva observación de la categoría:');
            $.ajax({
                url: './controller/categoria.php?op=Update',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ cat_id: catId, cat_nom: catNom, cat_obs: catObs }),
                dataType: 'json',
                success: function(data) {
                    displayResponse(data.Alert);
                    getAllCategories(); 
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function deleteCategory(catId) {
            if (confirm('¿Estás seguro de que quieres eliminar esta categoría?')) {
                $.ajax({
                    url: './controller/categoria.php?op=Delete',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ cat_id: catId }),
                    dataType: 'json',
                    success: function(data) {
                        displayResponse(data.Alert);
                        getAllCategories(); 
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        function displayResponse(message) {
            alert(message);
        }
    </script>
</body>
</html>
