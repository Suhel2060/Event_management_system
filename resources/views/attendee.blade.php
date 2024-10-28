@extends('layouts.mainlayout')
@section('body-section')
    @extends('layouts.navlayout')
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Use modal-lg for a larger modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Attendee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Modal body content goes here -->
                    <form id="attendeeupdateform" method="POST" action="{{ url('api/attendee/update') }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row"> <!-- Start a new row -->
                            <div class="col-md-6 mb-3"> <!-- First column -->
                                <label for="update-name" class="form-label">Enter Name</label>
                                <input type="text" class="form-control" id="update-name" name="update_name">
                                <div id="updatename-error" class="text-danger"></div>
                            </div>
                            <div class="col-md-6 mb-3"> <!-- Second column -->
                                <label for="update-email" class="form-label">Enter Email</label>
                                <input type="email" class="form-control " id="update-email" name="update_email">
                                <div id="updateemail-error" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="updateevent_id" class="form-label">Event</label>
                                <select class="form-select" aria-label="Default select example" id="updateevent_id"
                                    name="updateevent_id">
                                    <option selected value="">Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                                    @endforeach
                                </select>
                                <div id="updateevent-error" class="text-danger"></div>
                            </div>
                        </div>
                        <!-- Add more rows and columns as needed -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="updateBtn">Update Attendee</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container my-5 w-100">

        <h2 class="text-center mb-4">Attendee Management</h2>

        <div class="card mb-4">
            <div class="card-header text-center">
                <h4>Add New Attendee</h4>
            </div>
            <div class="card-body">
                <form id="attendeeForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Name">
                            <div id="name-error" class="text-danger"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" cols="30"
                                rows="3" placeholder="Enter Email"></input>
                            <div id="email-error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="event_id" class="form-label">Event</label>
                                <select class="form-select" aria-label="Default select example" id="event_id"
                                    name="event_id">
                                    <option selected value="">Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                                    @endforeach
                                </select>
                                <div id="event-error" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-50 text-center">Add Attendee</button>
                        </div>

                </form>
            </div>
        </div>
    </div>

    <div class="container my-5">

        <div class="card">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p></p>
                    <h4 class="text-center m-0">Attendee List</h4>

                    <form id="searchForm text-center" class="d-flex w-5">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search"
                                placeholder="Search by Name, Email, or Event">
                        </div>
                    </form>
                </div>
                <!-- Card body content here if needed -->
            </div>



            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="itemTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Event</th>
                            <th>Edit</th>
                            <th>Delete</th>

                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach ($attendees as $attendee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attendee->name }}</td>
                                <td>{{ $attendee->email }}</td>
                                <td>{{ $attendee->Event->title }}</td>
                            
                                <td><i class="fa-solid fa-pen-to-square editattendee" id="{{ $attendee->id }}"></i></td>
                                <td><i class="fa-solid fa-trash deleteattendee" id="{{ $attendee->id }}"></i></td>

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


            //for getting the data to be editted
            $('.table-body').on("click", '.editattendee', function() {
                const attendee_id = $(this).attr('id');
                update_id = attendee_id;
                $.ajax({
                    type: "get",
                    url: `{{ url('api/attendee/edit') }}/${update_id}`,
                    success: function(response) {
                        $("#myModal").modal('show');
                        console.log(response.data)
                        $('#update-name').val(response.data[0].name);
                        $('#update-email').val(response.data[0].email);
                        $('#updateevent_id').val(response.data[0].event_id).trigger(
                            'change');
                    }
                });
            });



            //store the data of attendee
            $('#attendeeForm').submit(function(e) {
                let status = true;
                e.preventDefault();
                const formdata = new FormData(this);
                (!formdata.get('name') || formdata.get('name').length === 0) ?
                ($('#name-error').text('Name is required'), status = false) : $('#name-error').text('');

                (!formdata.get('email') || formdata.get('email').length === 0) ?
                ($('#email-error').text('Email is required'), status = false) : $('#email-error').text('');

                (!formdata.get('event_id')) ?
                ($('#event-error').text('Event is required'), status = false) : $('#event-error').text('');

                if (status) {
                    $.ajax({
                        type: "POST",
                        url: "/api/attendee/store",
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            updateTable(response,true);
                            $('#attendeeForm')[0].reset();
                            $('#event_id').val('').trigger(
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


            //update the data of attendee
            $('#attendeeupdateform').submit(function(e) {
                e.preventDefault();
                let status = true;
                let update_email = $('#update-email').val()
                let update_name = $('#update-name').val()
                let updateevent_id = $('#updateevent_id').val()
                const formdata = new FormData(this);
                (!update_name || update_name.length === 0) ?
                ($('#updatename-error').text('Name is required'), status = false) : $('#updatename-error')
                    .text('');

                (!update_email || update_email.length === 0) ?
                ($('#updateemail-error').text('Email is required'), status = false) : $(
                        '#updateemail-error')
                    .text('');

                (!updateevent_id) ?
                ($('#updateevent-error').text('Event is required'), status = false) : $(
                        '#updateevent-error')
                    .text('');
                if (status) {
                    $.ajax({
                        type: "PUT",
                        url: `{{ url('api/attendee/update') }}/${update_id}`,
                        // data:formdata,
                        // processData: false,
                        // contentType: false
                        data: JSON.stringify({
                            update_email: update_email,
                            update_name: update_name,
                            updateevent_id: updateevent_id
                        }),
                        contentType: "application/json",
                        success: function(response) {
                            console.log(response)
                            updateTable(response,true);
                            $('#myModal').modal('hide');

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


            //delete data of attendee
            $('.table-body').on('click', '.deleteattendee', function(e) {
                e.preventDefault();
                const attendeet_id = $(this).attr('id');
                $.ajax({
                    type: "Delete",
                    url: `{{ url('api/attendee/delete') }}/${attendeet_id}`,
                    success: function(response) {
                        updateTable(response,true);
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
            })


            //search data of attendee
            $('#search').on('input', function() {
            const query = $(this).val();
            search(query);
        });

        function search(query) {
            $.ajax({
                url: '/api/attendee/search',
                type: 'GET',
                data: {
                    search: query
                },
                success: function(response) {
                    updateTable(response,false);
                }
            });
        }



            function updateTable(response,showalert) {
                let html = '';
                let id = 1;
                $.each(response.data, function(indexInArray, valueOfElement) {
                    html += `<tr>
    <td>${id++}</td>
    <td>${valueOfElement.name}</td>
    <td>${valueOfElement.email}</td>
    <td>${valueOfElement.event.title}</td>

        <td><i class="fa-solid fa-pen-to-square editattendee" id="${valueOfElement.id}"></i></td>
    <td><i class="fa-solid fa-trash deleteattendee" id="${valueOfElement.id}"></i></td>

    </tr>`
                });
                $('.table-body').empty();
                $('.table-body').append(html);
                if(showalert){
                    Swal.fire({
                    title: "Successful",
                    text: response.message,
                    icon: "success"
                });
                }
               
            }
        });


    
    </script>
@endsection
