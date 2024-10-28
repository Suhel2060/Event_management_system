@extends('layouts.mainlayout')
@section('body-section')
    @extends('layouts.navlayout')
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Modal body content goes here -->
                    <form id="myForm">
                        <div class="mb-3">
                            <label for="inputField2" class="form-label">Enter Category</label>
                            <input type="text" class="update-category" id="update-category" required>
                            <div id="updatecategoryname-error" class="text-danger"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateBtn">Update Category</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5 w-50">

        <h2 class="text-center mb-4">Category Management</h2>

        <div class="card mb-4">
            <div class="card-header text-center">
                <h4>Add New Category</h4>
            </div>
            <div class="card-body">
                <form id="categoryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Category">
                        <div id="categoryname-error" class="text-danger"></div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-50 text-center">Add Category</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="container my-5">

        <div class="card">
            <div class="card-header text-center">
                <h4>Category List</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="itemTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach ($category as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td><i class="fa-solid fa-pen-to-square editcategory" id="{{ $category->id }}"></i></td>
                                <td><i class="fa-solid fa-trash deletecategory" id="{{ $category->id }}"></i></td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let update_id;
            $('#categoryForm').submit(function(e) {
                e.preventDefault();
                let status = true;
                const categoryname = $('#name').val();
                console.log(categoryname)
                if (!categoryname || categoryname.length < 1) {
                    $('#categoryname-error').text('Category name is required');
                    status = false;
                } else {
                    $('#categoryname-error').text('');
                    status = true;
                }

                if (status) {

                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/category/store') }}",
                        data: {
                            'category': categoryname
                        },
                        success: function(response) {
                            console.log(response)
                            updateTable(response);

                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.status)
                            if (xhr.status == 422)
                                Swal.fire({
                                    title: "error",
                                    text: xhr.responseJSON.message.category[0],
                                    icon: "error"
                                });

                            if (xhr.status == 500)
                                Swal.fire({
                                    title: "error",
                                    text: xhr.responseJSON.message,
                                    icon: "error"
                                });
                        }
                    });
                }

            });


            $('.table-body').on('click','.editcategory', function (e) {
                e.preventDefault();
                const category_id = $(this).attr('id');
                update_id = category_id;
                $.ajax({
                    type: "GET",
                    url: `{{ url('api/category/edit/${category_id}') }}`,
                    success: function(response) {
                        console.log(response)
                        $('#myModal').modal('show');
                        $('#update-category').val(response.data.name);
                    }
                });
            });





            $('#updateBtn').click(function(e) {
                e.preventDefault();
                let status = true;
                const categoryname = $('#update-category').val();
                console.log(categoryname)
                if (!categoryname || categoryname.length < 1) {
                    $('#updatecategoryname-error').text('Category name is required');
                    status = false;
                } else {
                    $('#updatecategoryname-error').text('');
                    status = true;
                }
                if (status) {

                    $.ajax({
                        type: "PUT",
                        url: `{{ url('api/category/update/${update_id}') }}`,
                        data: {
                            'categoryname': categoryname
                        },
                        success: function(response) {
                            console.log(response)
                            updateTable(response);
                            $('#myModal').modal('hide');

                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.status)
                            if (xhr.status == 422)
                                Swal.fire({
                                    title: "error",
                                    text: xhr.responseJSON.message.category[0],
                                    icon: "error"
                                });

                            if (xhr.status == 500)
                                Swal.fire({
                                    title: "error",
                                    text: xhr.responseJSON.message,
                                    icon: "error"
                                });
                        }
                    });
                }

            });

            

            $('.table-body').on('click','.deletecategory', function (e) {
                e.preventDefault();
                const delete_id=$(this).attr('id');
                    $.ajax({
                        type: "DELETE",
                        url: `{{ url('api/category/delete/${delete_id}') }}`,
                        success: function(response) {
                            updateTable(response);

                        },
                        error: function(xhr, status, error) {
                            if (xhr.status == 500)
                                Swal.fire({
                                    title: "error",
                                    text: xhr.responseJSON.message,
                                    icon: "error"
                                });
                        }
                    });
            });
        });






        function updateTable(response) {
            let html = '';
            let id = 1;
            $.each(response.data, function(indexInArray, valueOfElement) {
                console.log(response)
                html += `<tr>
    <td>${id++}</td>
    <td>${valueOfElement.name}</td>
        <td><i class="fa-solid fa-pen-to-square editcategory" id="${valueOfElement.id}"></i></td>
    <td><i class="fa-solid fa-trash deletecategory" id="${valueOfElement.id}"></i></td>

    </tr>`
            });
            $('.table-body').empty();
            $('.table-body').append(html);
            $('#update-category').val()
            Swal.fire({
                title: "Successful",
                text: response.message,
                icon: "success"
            });
        }
    </script>
@endsection
