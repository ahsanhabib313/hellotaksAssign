@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Employee') }}</div>

                <div class="card-body">
                  
                        <div class="alert alert-success d-none" role="alert">
                            Employee has been added successfully
                        </div>
                        <div class="alert alert-warning d-none" role="alert">
                           
                        </div>

                    <form id="employee_form" enctype="multipart/form-data">
                     
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="first_name">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name">
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <select class="form-control" name="company_id">
                                <option selected disabled>select company</option>
                                @isset($companies)
                                       @foreach($companies as $company)
                                         <option value="{{ $company->id }}">{{ $company->name }}</option>
                                       @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control"  name="email">
                        </div>
                       
                         <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-info" id="submit">Submit</button>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
             <table class="table table-bordered" id="employee_table">
                <thead>
                     <tr>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Company</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Action</th>
                  </tr>
                </thead>
                 
                  <tbody>
                      
                  </tbody>
             </table>
        </div>               
    </div>
</div>

    <div class="modal" tabindex="-1" role="dialog" id="editModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Employee</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
               <form id="editForm" enctype="multipart/form-data">
                            <div class="alert alert-success d-none" role="alert">
                                Employee has been Updated successfully
                            </div>
                            <div class="alert alert-warning d-none" role="alert">
                               
                            </div>
                               <input type="hidden" name="id">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="first_name">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="last_name">
                                </div>
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control" name="company_id">
                                    
                                        @isset($companies)
                                               @foreach($companies as $company)
                                                 <option class="company_option" value="{{ $company->id }}">{{ $company->name }}</option>
                                               @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control"  name="email">
                                </div>
                               
                                 <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-info" id="update">update</button>
                                </div>
                    </form>


          </div>
         
        </div>
      </div>
    </div>s


    @section('script')

 <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

            <script type="text/javascript">

             
                    $( document ).ready(function() {
                        
                        $('#submit').on('click',function(e){

                            e.preventDefault();
                           
                            let first_name = $('input[name="first_name"]').val();
                            let last_name = $('input[name="last_name"]').val();
                            let company_id = $('select[name="company_id"]').val();
                            let email = $('input[name="email"]').val();
                            let phone = $('input[name="phone"]').val();

                            let formData = new FormData();

                            formData.append('first_name',first_name);
                            formData.append('last_name',last_name);
                            formData.append('company_id',company_id);
                            formData.append('email',email);
                            formData.append('phone',phone);

                           $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                       
                            $.ajax({
                                url:"{{ route('employees.store') }}",
                                method:"POST",
                                dataType:'json',
                                data:formData,
                                processData:false,
                                contentType:false,
                                cache:false,
                                enctype:'multipart/form-data',
                                success: function(response){

                                    if(response.status == 200){
                                        $('#employee_form')[0].reset();
                                        $('#employee_table').DataTable().ajax.reload();
                                        $('.alert-success').removeClass('d-none');

                                        setTimeout(function(){
                                            $('.alert-success').addClass('d-none');
                                        },3000)
                                    }

                                   

                                },
                                error:function(response){
                                    
                                    if( response.status === 422 ) {

                                        var response = JSON.parse(response.responseText);
                                                var errorString = '<ul>';
                                                $.each( response.errors, function( key, value) {
                                                    errorString += '<li>' + value + '</li>';
                                                });
                                                errorString += '</ul>';

                                            $('.alert-warning').html(errorString);
                                            $('.alert-warning').removeClass('d-none');

                                            setTimeout(function(){
                                                $('.alert-warning').addClass('d-none');
                                            },3000)
                                    }
                                }

                            })
                            
                    })



                 


                     $('#employee_table').DataTable({
                    ajax:"{{ route('getEmployee') }}",
                    columns:[
                    {
                        data:'first_name'
                    },
                    {
                        data:'last_name'
                    },
                    {
                        data:'company.name'
                    },
                    {
                        data:'email'
                    },
                  
                    {
                        data:'phone'
                       
                    },
                    {
                        data:null,
                        render:function(data,row, type){
                                
                                return `<button type="button" class="btn btn-success"  onclick="editEmployee(${data.id})" data-toggle="modal" data-target="#editModal">Edit</button>
                      <button type="button" class="btn btn-warning" onclick="deleteEmployee(${data.id})">Delete</button>`
                        }
                    }
                    ]
                 })
                           
                });

                    $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                 /*** get employee value for edition ***/
                        function editEmployee(id){
                                        
                                $.ajax({
                                    url:'/employees/'+id+'/edit',
                                    method:'GET',
                                    processData:false,
                                    contentType:false,
                                    success:function(response){

                                        if(response.status == 200){
                                              
                                            $('#editForm').find('input[name="id"]').val(response.data.id);
                                            $('#editForm').find('input[name="first_name"]').val(response.data.first_name);
                                            $('#editForm').find('input[name="last_name"]').val(response.data.last_name);
                                            $('#editForm').find('select option').each(function(){

                                                if($(this).val() == response.data.company_id){

                                                     $(this).attr('selected','selected');
                                                }
                                            })
                                            $('#editForm').find('input[name="email"]').val(response.data.email);
                                            $('#editForm').find('input[name="phone"]').val(response.data.phone);

                                        }

                                    },
                                    error:function(response){

                                    }
                                })
                                    
                            }


                /***** update the company ***/
                       $('#update').on('click', function(){

                             let id = $('#editForm').find('input[name="id"]').val();
                             let first_name = $('#editForm').find('input[name="first_name"]').val();
                             let last_name = $('#editForm').find('input[name="last_name"]').val();
                             let company_id = $('#editForm').find('select[name="company_id"]').val();
                             let email = $('#editForm').find('input[name="email"]').val();
                             let phone = $('#editForm').find('input[name="phone"]').val();


                             const fd = new FormData();

                             fd.append('id',id);
                             fd.append('first_name',first_name);
                             fd.append('last_name',last_name);
                             fd.append('company_id',company_id);
                             fd.append('email',email);
                             fd.append('phone',phone);


                             $.ajax({
                                url:"{{ route('employee.update') }}",
                                method:"POST",
                                data: fd,
                                dataType:'JSON',
                                processData:false,
                                contentType:false,
                                cache:false,
                                success:function(response){

                                     if(response.status == 200){
                                       
                                        $('.alert-success').removeClass('d-none');

                                        setTimeout(function(){
                                            $('#editForm .alert-success').addClass('d-none');
                                             $("#editModal").modal('hide');
                                            $('#employee_table').DataTable().ajax.reload();
                                        },3000)
                                    }



                                },
                                error: function(response){

                                     if( response.status === 422 ) {

                                        var response = JSON.parse(response.responseText);
                                                var errorString = '<ul>';
                                                $.each( response.errors, function( key, value) {
                                                    errorString += '<li>' + value + '</li>';
                                                });
                                                errorString += '</ul>';

                                            $('#editForm .alert-warning').html(errorString);
                                            $('#editForm .alert-warning').removeClass('d-none');

                                            setTimeout(function(){
                                                $('.alert-warning').addClass('d-none');
                                            },3000)
                                    }

                                }
                             })


                       })


                       /****** delete employee ********/
                       function deleteEmployee(id){

                             if(confirm('Do you want to delete the employee')){


                                       $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                   
                                        $.ajax({
                                            url:`/employee/${id}/delete`,
                                            method:"GET",
                                            processData:false,
                                            contentType:false,
                                            cache:false,
                                            success: function(response){

                                                if(response.status == 200){
                                                   $('#employee_table').DataTable().ajax.reload();
                                                }
                                               
                                            },
                                            error:function(response){
                                            
                                               
                                            }

                                        })

                             }else{

                             }
                       }
                  </script>




       

    @endsection

@endsection
