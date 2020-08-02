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
            content += '<button type="button" class="btn btn-danger btn-sm">Delete</button>';
            content += '</div>';
            return content;
          }
        }
    ]
  } );
} );