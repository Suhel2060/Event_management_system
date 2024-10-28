@extends('layouts.mainlayout')
@section('body-section')
    @extends('layouts.navlayout')
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Use modal-lg for a larger modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Modal body content goes here -->
                    <form id="eventupdateform" method="POST" action="{{ url('api/event/update') }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row"> <!-- Start a new row -->
                            <div class="col-md-6 mb-3"> <!-- First column -->
                                <label for="update-title" class="form-label">Enter title</label>
                                <input type="text" class="form-control" id="update-title" name="update_title">
                                <div id="updatetitlename-error" class="text-danger"></div>
                            </div>
                            <div class="col-md-6 mb-3"> <!-- Second column -->
                                <label for="update-description" class="form-label">Enter Description</label>
                                <input type="text" class="form-control " id="update-description"
                                    name="update_description">
                                <div id="updatedescription-error" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="update-date" class="form-label">Enter Date</label>
                                <input type="text" class="form-control update-date date-picker" id="update-date"
                                    name="update_date">
                                <div id="updatedate-error" class="text-danger"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="update-location" class="form-label">Enter Location</label>
                                <input type="text" class="form-control" id="update-location" name="update_location">
                                <div id="updatelocation-error" class="text-danger"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="updatecategory_id" class="form-label">Category</label>
                                <select class="form-select" aria-label="Default select example" id="updatecategory_id"
                                    name="updatecategory_id">
                                    <option selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div id="updatecategory-error" class="text-danger"></div>
                            </div>
                        </div>
                        <!-- Add more rows and columns as needed -->

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateBtn">Update Category</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5 w-100">

        <h2 class="text-center mb-4">Event Management</h2>

        <div class="card mb-4">
            <div class="card-header text-center">
                <h4>Add New Event</h4>
            </div>
            <div class="card-body">
                <form id="eventForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Enter Title">
                            <div id="title-error" class="text-danger"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="3"
                                placeholder="Enter Description"></textarea>
                            <div id="description-error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="text" class="form-control date-picker" id="date" name="date">
                            <div id="date-error" class="text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="Location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location"
                                placeholder="Enter Location">
                            <div id="location-error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" aria-label="Default select example" id="category_id"
                                name="category_id">
                                <option selected value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="category-error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-50 text-center">Add Event</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="container my-5">

        <div class="card">
            <div class="card-header text-center">
                <h4>Event List</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="itemTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>

                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach ($events as $event)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->description }}</td>
                                <td>{{ $event->date }}</td>
                                <td>{{ $event->location }}</td>
                                <td>{{ $event->Category->name }}</td>
                                <td><i class="fa-solid fa-pen-to-square editevent" id="{{ $event->id }}"></i></td>
                                <td><i class="fa-solid fa-trash deleteevent" id="{{ $event->id }}"></i></td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let update_id = '';

            $(".date-picker").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: new Date(), // Disable past dates
                maxDate: "+1Y", // Disable dates more than 1 month from today
            });


            $('.table-body').on("click", '.editevent', function() {
                const event_id = $(this).attr('id');
                update_id = event_id;
                $.ajax({
                    type: "get",
                    url: `{{ url('api/event/edit') }}/${update_id}`,
                    success: function(response) {
                        $("#myModal").modal('show');
                        console.log(response.data)
                        $('#update-title').val(response.data[0].title);
                        $('#update-description').val(response.data[0].description);
                        $('#update-date').val(response.data[0].date);
                        $('#update-location').val(response.data[0].location);
                        $('#updatecategory_id').val(response.data[0].category_id).trigger(
                            'change');
                    }
                });
            });

            $('#updateBtn').click(function(e) {
                e.preventDefault();

                let status = true;
                let update_title, update_description, updated_date, update_location, updatecategory_id;
                update_title = $('#update-title').val();
                update_description = $('#update-description').val();
                update_date = $('#update-date').val();
                update_location = $('#update-location').val();
                updatecategory_id = $('#updatecategory_id').val();
                (!update_title || update_title.length == 0) ?
                ($('#updatetitle-error').text('Title is required'), status = false) : $(
                    'update#title-error').text('');

                (!update_description || update_description.length == 0) ?
                ($('#updatedescription-error').text('Description is required'), status = false) : $(
                    '#updatedescription-error').text('');

                (!update_date) ?
                ($('#updatedate-error').text('Date is required'), status = false) : $('#updatedate-error')
                    .text('');
                if (status) {

                    $.ajax({
                        type: "PUT",
                        url: `{{ url('api/event/update') }}/${update_id}`,
                        data: JSON.stringify({
                            update_title: update_title,
                            update_description: update_description,
                            update_date: update_date,
                            update_location: update_location,
                            updatecategory_id: updatecategory_id
                        }),
                        contentType: "application/json",

                        success: function(response) {
                            console.log(response)
                            updateTable(response);
                            $('#myModal').modal('hide');
                            $('#eventForm')[0].reset();
                            $('#category_id').val('').$('#category_id').val('').trigger(
                                'change');

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



            $('#eventForm').submit(function(e) {
                let status = true;
                e.preventDefault();
                const formdata = new FormData(this);

                console.log(formdata);


                (!formdata.get('title') || formdata.get('title').length === 0) ?
                ($('#title-error').text('Title is required'), status = false) : $('#title-error').text('');

                (!formdata.get('description') || formdata.get('description').length === 0) ?
                ($('#description-error').text('Description is required'), status = false) : $(
                    '#description-error').text('');

                (!formdata.get('date')) ?
                ($('#date-error').text('Date is required'), status = false) : $('#date-error').text('');


                if (status) {
                    $.ajax({
                        type: "POST",
                        url: "/api/event/store",
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response)
                            updateTable(response);
                            $('#eventForm')[0].reset();
                            $('#category_id').val('').$('#category_id').val('').trigger(
                                'change');
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
                }
            });

            $('.table-body').on('click','.deleteevent',function(e) {
                e.preventDefault();
                const event_id = $(this).attr('id');
                $.ajax({
                    type: "Delete",
                    url: `{{ url('api/event/delete') }}/${event_id}`,
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




            function updateTable(response) {
                let html = '';
                let id = 1;
                $.each(response.data, function(indexInArray, valueOfElement) {
                    html += `<tr>
    <td>${id++}</td>
    <td>${valueOfElement.title}</td>
    <td>${valueOfElement.description}</td>
    <td>${valueOfElement.date}</td>
    <td>${valueOfElement.location}</td>
    <td>${valueOfElement.category?valueOfElement.category.name:"Null"}</td>

        <td><i class="fa-solid fa-pen-to-square editevent" id="${valueOfElement.id}"></i></td>
    <td><i class="fa-solid fa-trash deleteevent" id="${valueOfElement.id}"></i></td>

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
        });
    </script>
@endsection
