<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Client</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="getAllProducts()">
    <a href="./Consumir.php">Volver</a>
    <button onclick="getProductById()">Obtener producto por ID</button>
    <button onclick="insertProduct()">Insertar producto</button>
    <table id="productTable" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>ID Categoría</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="productBody">
        </tbody>
    </table>
    <div id="response" style="margin-top: 20px;"></div>

    <script>
        function displayProduct(products) {
            var productBody = $('#productBody');
            productBody.empty();

            products.forEach(function(product) {
                var row = '<tr>' +
                            '<td>' + product.pro_id + '</td>' +
                            '<td>' + product.pro_nom + '</td>' +
                            '<td>' + product.pro_des + '</td>' +
                            '<td>' + product.pro_cat_id + '</td>' +
                            '<td>' + product.pro_cat_nom + '</td>' +
                            '<td>' +
                                '<button onclick="updateProduct(' + product.pro_id + ')">Actualizar</button>' +
                                '<button onclick="deleteProduct(' + product.pro_id + ')">Eliminar</button>' +
                            '</td>' +
                          '</tr>';
                productBody.append(row);
            });
        }

        function getAllProducts() {
            $.ajax({
                url: 'controller/producto.php?op=GetAll',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    displayProduct(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function getProductById() {
            var proId = prompt('Ingrese el ID del producto:');
            $.ajax({
                url: './controller/producto.php?op=GetId',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ pro_id: proId }),
                dataType: 'json',
                success: function(data) {
                    displayProduct(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function insertProduct() {
            var proNom = prompt('Ingrese el nombre del producto:');
            var proDes = prompt('Ingrese la descripción del producto:');
            var proCatId = prompt('Ingrese el ID de la categoría:');
            $.ajax({
                url: './controller/producto.php?op=Insert',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ pro_nom: proNom, pro_des: proDes, pro_cat_id: proCatId }),
                dataType: 'json',
                success: function(data) {
                    displayResponse(data.Alert);
                    getAllProducts(); 
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function updateProduct(proId) {
            var proNom = prompt('Ingrese el nuevo nombre del producto:');
            var proDes = prompt('Ingrese la nueva descripción del producto:');
            var proCatId = prompt('Ingrese el nuevo ID de la categoría:');
            $.ajax({
                url: './controller/producto.php?op=Update',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ pro_id: proId, pro_nom: proNom, pro_des: proDes, pro_cat_id: proCatId }),
                dataType: 'json',
                success: function(data) {
                    displayResponse(data.Alert);
                    getAllProducts(); 
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function deleteProduct(proId) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                $.ajax({
                    url: './controller/producto.php?op=Delete',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ pro_id: proId }),
                    dataType: 'json',
                    success: function(data) {
                        displayResponse(data.Alert);
                        getAllProducts(); 
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
