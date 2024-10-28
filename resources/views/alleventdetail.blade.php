@extends('layouts.mainlayout')
@section('body-section')
    @extends('layouts.navlayout')
   
    <div class="container my-5">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <p></p>
                <h4 class="text-center m-0">Event and Attendee List</h4>

                <form id="searchForm text-center" class="d-flex w-5">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search"
                            placeholder="Search by Name, Email, or Event">
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="itemTable">
                    <thead class="table-dark">
                        <tr>
                            <th>S.N</th>
                            <th>Attendee Name</th>
                            <th>Attendee Email</th>
                            <th>Event Name</th>
                            <th>Event Location</th>
                            <th>Event Date</th>
                            <th>Event Category</th>

                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->event->title }}</td>
                                <td>{{ $data->event->location }}</td>
                                <td>{{ $data->event->date }}</td>
                                <td>{{ $data->event->category->name }}</td>
                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#search').on('input', function() {
            const query = $(this).val();
            search(query);
        });

            function search(query) {
            $.ajax({
                url: '/api/search',
                type: 'GET',
                data: {
                    search: query
                },
                success: function(response) {
                    updateTable(response,false);
                }
            });
        }


        function updateTable(response) {
                let html = '';
                let id = 1;
                $.each(response.data, function(indexInArray, valueOfElement) {
                    html += `<tr>
    <td>${id++}</td>
    <td>${valueOfElement.name}</td>
    <td>${valueOfElement.email}</td>
    <td>${valueOfElement.event.title}</td>
    <td>${valueOfElement.event.location}</td>
    <td>${valueOfElement.event.date}</td>
    <td>${valueOfElement.event.category.name}</td>


    </tr>`
                });
                $('.table-body').empty();
                $('.table-body').append(html);

               
            }


        });


    </script>
@endsection
