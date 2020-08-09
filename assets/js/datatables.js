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


  $('#users_datatable').DataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": $("#users_datatable").attr("url"),
      "type": "POST"
    },
    "columns": [
      { "data": "id" },
      { "data": "name" },
      { "data": "email" },
      { "data": "user_role" },
      { "data": "collection_center" },
      { "data": "modified_at" },
      { "data": null, 
        className: "center", 
        render: function(data, type) {
          let content = "";
          content = '<div class="btn-group" role="group" aria-label="Action Button">';
          content += '<a href="/users/edit/'+data.id+'" class="btn btn-info btn-sm">Edit</a>';
          content += '<a href="/users/delete/'+data.id+'" id="'+data.id+'" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
          content += '</div>';
          return content;
        }
      }
  ]
} );


$('#categories_datatable').DataTable( {
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": $("#categories_datatable").attr("url"),
    "type": "POST"
  },
  "columns": [
    { "data": "id" },
    { "data": "name" },
    { "data": null, 
      className: "center", 
      render: function(data, type) {
        let content = "";
        content = '<div class="btn-group" role="group" aria-label="Action Button">';
        content += '<a href="/settings/paddy_categories/'+data.id+'" class="btn btn-info btn-sm">Edit</a>';
        content += '<a href="/settings/delete_paddy_categories/'+data.id+'" id="'+data.id+'" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
        content += '</div>';
        return content;
      }
    }
]
} );


$('#seasons_datatable').DataTable( {
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": $("#seasons_datatable").attr("url"),
    "type": "POST"
  },
  "columns": [
    { "data": "id" },
    { "data": "name" },
    { "data": null, 
      className: "center", 
      render: function(data, type) {
        let content = "";
        content = '<div class="btn-group" role="group" aria-label="Action Button">';
        if(data.id > 2) {
          content += '<a href="/settings/paddy_seasons/'+data.id+'" class="btn btn-info btn-sm">Edit</a>';
          content += '<a href="/settings/delete_paddy_seasons/'+data.id+'" id="'+data.id+'" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
        }
        content += '</div>';
        return content;
      }
    }
]
} );


$('#vehicle_datatable').DataTable( {
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": $("#vehicle_datatable").attr("url"),
    "type": "POST"
  },
  "columns": [
    { "data": "id" },
    { "data": "reg_no" },
    { "data": "vehicle_type" },
    { "data": "modified_at" },
    { "data": null, 
      className: "center", 
      render: function(data, type) {
        let content = "";
        content = '<div class="btn-group" role="group" aria-label="Action Button">';
        content += '<a href="/vehicles/edit/'+data.id+'" class="btn btn-info btn-sm">Edit</a>';
        content += '<a href="/vehicles/delete/'+data.id+'" id="'+data.id+'" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
        content += '</div>';
        return content;
      }
    }
]
} );


$('#vehicle_types_datatable').DataTable( {
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": $("#vehicle_types_datatable").attr("url"),
    "type": "POST"
  },
  "columns": [
    { "data": "id" },
    { "data": "name" },
    { "data": null, 
      className: "center", 
      render: function(data, type) {
        let content = "";
        content = '<div class="btn-group" role="group" aria-label="Action Button">';
        content += '<a href="/settings/vehicle_types/'+data.id+'" class="btn btn-info btn-sm">Edit</a>';
        content += '<a href="/settings/delete_vehicle_type/'+data.id+'" id="'+data.id+'" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
        content += '</div>';
        return content;
      }
    }
]
} );



$('#purchase_datatable').DataTable( {
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": $("#purchase_datatable").attr("url"),
    "type": "POST"
  },
  "columns": [
    { "data": "id" },
    { "data": "farmer_name" },
    { "data": "collection_center"},
    { "data": "collection_date"},
    { "data": null, 
      className: "center", 
      render: function(data, type) {
        let content = "";
        content = '<div class="btn-group" role="group" aria-label="Action Button">';
        content += '<a href="/settings/vehicle_types/'+data.id+'" class="btn btn-info btn-sm">Edit</a>';
        content += '<a href="/settings/delete_vehicle_type/'+data.id+'" id="'+data.id+'" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
        content += '</div>';
        return content;
      }
    }
]
} );


  } );