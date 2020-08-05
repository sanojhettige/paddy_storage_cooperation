$(document).ready(function() {
    $('#cc_datatable').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": $("#cc_datatable").attr("url"),
          "type": "POST"
        },
        "columns": [
          { "data": "id" },
          { "data": "name" },
          { "data": "city" },
          { "data": "address" },
          { "data": "capacity" },
          { "data": "modified_at" },
          { "data": null, 
            className: "center", 
            render: function(data, type) {
              let content = "";
              content = '<div class="btn-group" role="group" aria-label="Action Button">';
              content += '<a href="/collection-centers/edit/'+data.id+'" class="btn btn-info btn-sm">Edit</a>';
              content += '<a href="/collection-centers/delete/'+data.id+'" id="'+data.id+'" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
              content += '</div>';
              return content;
            }
          }
      ]
    } );
  } );



  $(document).ready(function() {
    $('#farmer_datatable').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": $("#farmer_datatable").attr("url"),
          "type": "POST"
        },
        "columns": [
          { "data": "id" },
          { "data": "name" },
          { "data": "nic_no" },
          { "data": "phone_number" },
          { "data": "land_size" },
          { "data": "modified_at" },
          { "data": null, 
            className: "center", 
            render: function(data, type) {
              let content = "";
              content = '<div class="btn-group" role="group" aria-label="Action Button">';
              content += '<a href="/farmers/edit/'+data.id+'" class="btn btn-info btn-sm">Edit</a>';
              content += '<a href="/farmers/delete/'+data.id+'" id="'+data.id+'" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
              content += '</div>';
              return content;
            }
          }
      ]
    } );
  } );