$(document).ready(function() {
    $('#cc_datatable').DataTable({
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
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.edit)
                        content += '<a href="/collection-centers/edit/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';

                    if (data.view)
                        content += '<a href="/collection-centers/view/' + data.id + '" class="btn btn-success btn-sm">View</a>';


                    if (data.delete)
                        content += '<a href="/collection-centers/delete/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';

                    content += '</div>';
                    return content;
                }
            }
        ]
    });


    $('#farmer_datatable').DataTable({
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
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.edit)
                        content += '<a href="/farmers/edit/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';

                    if (data.view)
                        content += '<a href="/farmers/view/' + data.id + '" class="btn btn-success btn-sm">View</a>';


                    if (data.delete)
                        content += '<a href="/farmers/delete/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    content += '</div>';
                    return content;
                }
            }
        ]
    });


    $('#customer_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": $("#customer_datatable").attr("url"),
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "company_name" },
            { "data": "email_address" },
            { "data": "phone_number" },
            { "data": "modified_at" },
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.edit)
                        content += '<a href="/customers/edit/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';

                    if (data.view)
                        content += '<a href="/customers/view/' + data.id + '" class="btn btn-success btn-sm">View</a>';

                    if (data.delete)
                        content += '<a href="/customers/delete/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    content += '</div>';
                    return content;
                }
            }
        ]
    });




    $('#users_datatable').DataTable({
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
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.edit)
                        content += '<a href="/users/edit/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';

                    if (data.delete)
                        content += '<a href="/users/delete/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    content += '</div>';
                    return content;
                }
            }
        ]
    });


    $('#categories_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": $("#categories_datatable").attr("url"),
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    content += '<a href="/settings/paddy_categories/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';
                    content += '<a href="/settings/delete_paddy_categories/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    content += '</div>';
                    return content;
                }
            }
        ]
    });


    $('#seasons_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": $("#seasons_datatable").attr("url"),
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "period" },
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.id > 2) {
                        content += '<a href="/settings/paddy_seasons/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';
                        content += '<a href="/settings/delete_paddy_seasons/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    }
                    content += '</div>';
                    return content;
                }
            }
        ]
    });


    $('#vehicle_datatable').DataTable({
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
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.edit)
                        content += '<a href="/vehicles/edit/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';

                    if (data.delete)
                        content += '<a href="/vehicles/delete/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    content += '</div>';
                    return content;
                }
            }
        ]
    });


    $('#vehicle_types_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": $("#vehicle_types_datatable").attr("url"),
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    content += '<a href="/settings/vehicle_types/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';
                    content += '<a href="/settings/delete_vehicle_type/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    content += '</div>';
                    return content;
                }
            }
        ]
    });



    $('#purchase_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": $("#purchase_datatable").attr("url"),
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "farmer_name" },
            { "data": "collection_center" },
            { "data": "collection_date" },
            { "data": "is_paid" },
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.edit) {
                        content += '<a href="/purchases/edit/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';
                    }

                    if (data.view) {
                        content += '<a href="/purchases/view/' + data.id + '" class="btn btn-success btn-sm">View</a>';
                    }

                    if (data.delete) {
                        content += '<a href="/purchases/delete/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    }

                    if (data.pay) {
                        content += '<a href="/purchases/pay/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm">Pay</a>';
                    }
                    content += '</div>';
                    return content;
                }
            }
        ]
    });


    $('#sale_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": $("#sale_datatable").attr("url"),
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "buyer_name" },
            { "data": "collection_center" },
            { "data": "issue_date" },
            { "data": "sale_status" },
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.edit)
                        content += '<a href="/sales/edit/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';

                    if (data.view)
                        content += '<a href="/sales/view/' + data.id + '" class="btn btn-success btn-sm">View</a>';

                    if (data.can_issue)
                        content += '<a href="/sales/issue/' + data.id + '" class="btn btn-success btn-sm">Issue</a>';


                    if (data.delete)
                        content += '<a href="/sales/delete/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    content += '</div>';
                    return content;
                }
            }
        ]
    });



    $('#transfer_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": $("#transfer_datatable").attr("url"),
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "from_center" },
            { "data": "to_center" },
            { "data": "transfer_date" },
            { "data": "transfer_status" },
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.edit)
                        content += '<a href="/transfers/edit/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';

                    if (data.view)
                        content += '<a href="/transfers/view/' + data.id + '" class="btn btn-success btn-sm">View</a>';

                    if (data.delete)
                        content += '<a href="/transfers/delete/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';

                    if (data.can_issue)
                        content += '<a href="/transfers/issue/' + data.id + '" id="' + data.id + '" class="btn btn-success btn-sm">Issue Now</a>';

                    if (data.can_collect)
                        content += '<a href="/transfers/collect/' + data.id + '" id="' + data.id + '" class="btn btn-success btn-sm">Collect Now</a>';

                    content += '</div>';
                    return content;
                }
            }
        ]
    });



    $('#money_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": $("#money_datatable").attr("url"),
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "collection_center" },
            { "data": "amount" },
            {
                "data": null,
                render: function(data, type) {
                    if (data.status === 1) {
                        return "Collected";
                    }
                    return "Pending";
                }
            },
            { "data": "modified_at" },
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    if (data.status <= 0) {
                        content += '<a href="/settings/money_allocation/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';

                        content += '<a href="/settings/delete_money_allocation/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';

                    }
                    content += '</div>';
                    return content;
                }
            }
        ]
    });


    $('#bank_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": $("#bank_datatable").attr("url"),
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "collection_center" },
            { "data": "bank_name" },
            { "data": "account_name" },
            { "data": "balance" },
            {
                "data": null,
                className: "center",
                render: function(data, type) {
                    let content = "";
                    content = '<div class="btn-group" role="group" aria-label="Action Button">';
                    content += '<a href="/settings/bank_accounts/' + data.id + '" class="btn btn-info btn-sm">Edit</a>';
                    content += '<a href="/settings/delete_bank_account/' + data.id + '" id="' + data.id + '" class="btn btn-danger btn-sm deleteRecord">Delete</a>';
                    content += '</div>';
                    return content;
                }
            }
        ]
    });


});