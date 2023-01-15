@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Company') }}</div>

                <div class="card-body">
                  
                        <div class="alert alert-success d-none" role="alert">
                            Company has been added successfully
                        </div>
                        <div class="alert alert-warning d-none" role="alert">
                           
                        </div>

                    <form id="company_form" enctype="multipart/form-data">
                     
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control"  name="email">
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" class="form-control" name="logo" placeholder="logo">
                        </div>
                         <div class="form-group">
                            <label>Website</label>
                            <input type="text" class="form-control" name="website">
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
             <table class="table table-bordered" id="company_table">
                <thead>

                      <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>logo</th>
                      <th>Website</th>
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
            <h5 class="modal-title">Edit Company</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
               <form id="editForm" enctype="multipart/form-data">
                        <div class="alert alert-success d-none" role="alert">
                            Company has been Updated successfully
                        </div>
                        <div class="alert alert-warning d-none" role="alert">
                           
                        </div>
                       <input type="hidden" name="id">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control"  name="email">
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" class="form-control" name="logo" placeholder="logo">
                        </div>
                         <div class="form-group">
                            <label>Website</label>
                            <input type="text" class="form-control" name="website">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-info" id="update">update</button>
                        </div>
                    </form>


          </div>
         
        </div>
      </div>
    </div>


    @section('script')

 <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

            <script type="text/javascript">

             
                    $( document ).ready(function() {
                        
                        $('#submit').on('click',function(e){

                            e.preventDefault();
                           
                            let name = $('input[name="name"]').val();
                            let email = $('input[name="email"]').val();
                            let logo = $('input[name="logo"]')[0].files[0];
                            let website = $('input[name="website"]').val();

                            let formData = new FormData();

                            formData.append('name',name);
                            formData.append('email',email);
                            formData.append('logo',logo);
                            formData.append('website',website);

                           $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                       
                            $.ajax({
                                url:"{{ route('companies.store') }}",
                                method:"POST",
                                dataType:'json',
                                data:formData,
                                processData:false,
                                contentType:false,
                                cache:false,
                                enctype:'multipart/form-data',
                                success: function(response){

                                    if(response.status == 200){
                                        $('#company_form')[0].reset();
                                        $('#company_table').DataTable().ajax.reload();
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



                 


                     $('#company_table').DataTable({
                    ajax:"{{ route('getCompany') }}",
                    columns:[{
                        data:'name'
                    },
                    {
                        data:'email'
                    },
                    {
                        data:null,
                        render:function(data,row,type){
                            return '<img width=100 height=100 src="'+location.origin+'/storage/company/'+data.logo+'">';
                        }
                    },
                    {
                        data:null,
                        render: function(data, row, type){
                            return `<a href="${data.website}" target=_blank>${data.website}</a>`;
                        }
                    },
                    {
                        data:null,
                        render:function(data,row, type){
                                
                                return `<button type="button" class="btn btn-success"  onclick="editCompany(${data.id})" data-toggle="modal" data-target="#editModal">Edit</button>
                      <button type="button" class="btn btn-warning" onclick="deleteCompany(${data.id})">Delete</button>`
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

                 /*** get company value for edition ***/
                        function editCompany(id){
                                        
                                $.ajax({
                                    url:'/companies/'+id+'/edit',
                                    method:'GET',
                                    processData:false,
                                    contentType:false,
                                    success:function(response){

                                        if(response.status == 200){
                                              
                                            $('#editForm').find('input[name="id"]').val(response.data.id);
                                            $('#editForm').find('input[name="name"]').val(response.data.name);
                                            $('#editForm').find('input[name="email"]').val(response.data.email);
                                            $('#editForm').find('input[name="website"]').val(response.data.website);

                                        }

                                    },
                                    error:function(response){

                                    }
                                })
                                    
                            }


                /***** update the company ***/
                       $('#update').on('click', function(){

                             let id = $('#editForm').find('input[name="id"]').val();
                             let name = $('#editForm').find('input[name="name"]').val();
                             let email = $('#editForm').find('input[name="email"]').val();
                             let logo = $('#editForm').find('input[name="logo"]')[0].files[0];
                             let website = $('#editForm').find('input[name="website"]').val();


                             const fd = new FormData();

                             fd.append('id',id);
                             fd.append('name',name);
                             fd.append('email',email);
                             fd.append('logo',logo);
                             fd.append('website',website);


                             $.ajax({
                                url:"{{ route('company.update') }}",
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
                                            $('#company_table').DataTable().ajax.reload();
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


                       /****** delete company ********/
                       function deleteCompany(id){

                             if(confirm('Do you want to delete the company')){


                                       $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                   
                                        $.ajax({
                                            url:`/company/${id}/delete`,
                                            method:"GET",
                                            processData:false,
                                            contentType:false,
                                            cache:false,
                                            success: function(response){

                                                if(response.status == 200){
                                                   $('#company_table').DataTable().ajax.reload();
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
