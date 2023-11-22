//function to show and hide 
function Toggle (item) {
    $(item).slideToggle();
}

//function to check if session is set 
function checkSession () {
    $.post("./php/check_session.php", function (data){
        if (data == 1) {
            location.href = "index.html";
            $(".sys_msg").html("Session Expired!"); 
        }
    });
}

//function to get main-data with pagination
function getMainData (table) {
    var limit = $("#limit").val();
    var currentPage = Number($("#current-page").val());
    var search = $("#search").val();
    
    //setting source files to get row counts
    if (!search || search == "" || search == " " || search == null) {
        var source = "row_count.php";
    }
    else {
        var source = "search_row_count.php";
    }
    
    //fetching data from the table
    fetchData(table);

    //getting row count
    $.post("./php/" + source, {
        table: table,
        search: search
        }, function (data) {
            var rowCount = data;
            var totalPages = Math.ceil (rowCount / limit);

            //displaing page number 
            var pageIndex = "Page " + currentPage + " of " + totalPages;
            $(".page-number").html(pageIndex);

            //setting up page numbers in pagination 
            if (currentPage == 1) {
                $("#pgbtn1").html(currentPage);
                $("#pgbtn2").html(currentPage + 1);
                $("#pgbtn3").html(currentPage + 2);
                $("#pgbtn4").html(currentPage + 3);
                $("#pgbtn5").html(currentPage + 4);
                $("#pgbtn6").html(currentPage + 5);
                $("#prev").attr("disabled", true);
            }
            else {
                $("#pgbtn1").html(currentPage - 1);
                $("#pgbtn2").html(currentPage);
                $("#pgbtn3").html(currentPage + 1);
                $("#pgbtn4").html(currentPage + 2);
                $("#pgbtn5").html(currentPage + 3);
                $("#pgbtn6").html(currentPage + 4);
                $("#prev").attr("disabled", false);
            }

            if (currentPage >= totalPages) {
                $("#next").attr("disabled", true);
            
            }
            else {
                $("#next").attr("disabled", false);
            }

            //looping all the page buttons to hide and disable current page 
            //and pages that don't exist.
            for (let i = 1; i <= 6; i++) {
                var pageNum = $("#pgbtn" + i).html();   
                
                //checking if pageNum is equal to currentPage
                if (pageNum == currentPage) {
                    //pgbtn for currentPage is disabled
                    $("#pgbtn" + i).attr("disabled", true);
                }
                else {
                    //pgn is enabled and remove the disabled attr of the btn
                    $("#pgbtn" + i).removeAttr("disabled");
                }

                //page number that are smaller than one are disabled 
                if (pageNum < 1) {
                    $("#pgbtn" + i).attr('disabled', true);
                }

                //page number that are larger than the last page num are disabled
                if (pageNum > totalPages) {
                    $("#pgbtn" + i).attr("disabled", true);
                }
                else {
                    $("#pgbtn" + i).removeAttr("disabled");
                }

                //disabling the next button on the last page
                if (pageNum >= totalPages) {
                    $("#next").attr("disabled", true);
                }
                else {
                    $("#next").attr("disabled", false);
                }

                if (currentPage < totalPages) {
                    $("#next").attr("disabled", false);
                }
            }
    });
}

// function to get main-data from the table 
function fetchData (table) {
    var page = $("#current-page").val();
    var order = $("#order").val();
    var limit = $("#limit").val();
    var search = $("#search").val();
    if (!search || search == "" || search == " " || search == null) {
        var src = "select_table_" + table + ".php";
        $.post("./php/" + src, {
            order: order,
            limit: limit,
            page: page
            }, function (data) {
                $(".main-data").html(data);    
        });
    }
    else {
        var src = "search_table_" + table + ".php   ";
        $.post("./php/" + src, {
            order: order,
            limit: limit,
            page: page,
            search: $("#search").val()
            }, function (data) {
                $(".main-data").html(data);
        });
    }
}

//function to preview image
function previewImage (input, name) {
    if (input.files && input.files[0]) {
        var img = document.getElementById(name).files[0];
        var imgName = img.name;
        var imgExt = imgName.split('.').pop().toLowerCase();
        if (jQuery.inArray(imgExt, ['jpg', 'jpeg', 'png']) == -1) {
            alert("Invalid Image Type! Only \".jpg & .jpeg\" files types are allowed!");
        }
        else {
            var imgPrev = new FileReader();
            imgPrev.onload = function (e) {
                $("#image_preview").attr("src", e.target.result);
            }
        }
        var imgSize = img.size;
        if (imgSize > 12000000) {
            alert("Image is too large!");
        }
        imgPrev.readAsDataURL(input.files[0]);
    }
}

//function to get an option list
function getOptionsList (table, option, selectId) {
    $.post("./php/get_options_list.php", {
        table: table,
        option: option
    }, function (data) {
        $("#" + selectId).append(data);
    });
}

//function to get the form to edit Invoices_Details
function getInvoicesDetailsModal(Link) {
    $.post("./php/edit_Invoices_Details_Modal.php", {Link: Link}, function (data) {
        $(".modal-wrap").html(data);
        $(".modal").show();  
    });
}

//function to close a modal 
function closeModal (modal) {
    var modal = document.getElementById(modal); 
    modal.style.display = "none"; 
}

//function to get modal for new Invoices_Details
function getNewInvoicesDetailsModal(InvoicesLink) {
    $.post("./php/add_Invoices_Details_Modal.php", {InvoicesLink: InvoicesLink}, function (data){
        $(".modal-wrap").html(data);
        $(".modal").show();
    });
}

//function to generate Invoices from Pro Forma Invoice
function generateInvoice (Link) {

    $.post("./php/generate_Invoices.php", {Link: Link}, function (data) {
        if (data == 0) {
            window.open("print_Invoices.html?Link=" + Link, "_blank");
        }
        else {
            $(".sys_msg").html("There was a connection error!");
        }
    });
}

//function to get Type: Stationary from the table Inventory
function getStationaryData (filter, col) {
    $.post("./php/select_table_Stationary.php", {filter: filter, col: col}, function(data) {
        $(".main-data").html(data);
    });
}

function getToiletriesData (filter, col) {
    $.post("./php/select_table_Toiletries.php", {filter: filter, col: col}, function(data){
        $(".main-data").html(data);
    });
}

function getAssetsData (filter, col) {
    $.post("./php/select_table_Assets.php", {filter, filter, col: col}, function(data) {
        $(".main-data").html(data);
    });
}

function filterInventoryList(col, table) {
    var filteredItem = $('#Inventory'+col ).find(":selected").text();
    if ($('#Inventory'+ col).find(":selected").text() == 'Select One') {
        //location.reload(); 
    }
    else {
        switch (table) {
            case 'Stationary':
                getStationaryData(filteredItem, col);
                break;
            case 'Toiletries':
                getToiletriesData(filteredItem, col);
                break;
            case 'Assets':
                getAssetsData(filteredItem, col);
                break;
            default:
                break;
        }
    }
}

//function to get total of Qty from the table Inventory
function getSumOfQtyInventory (filteredItem){
    $.post("./php/sum_Qty_Inventory.php", {filteredItem: filteredItem}, function (data) {
        $("#sum").val(data);
    });
}

//function to look up data by code
function lookupByCode (code, table, col, target) {
    if (code.trim().length >= 1){
        $.post ("./php/lookup_by_code.php", {code: code, table: table, col: col}, function (data) {
            if (data == 0) {
                $(".medium-button").attr("disabled", "disabled");
                $(".sys_msg").html("Please enter a proper code for your item!");
                $(".sys_msg").addClass("error-msg");
            }
            else {
                $("#" + target).html(data);
                $(".medium-button").removeAttr("disabled", "disabled");
            }
        });
    }
}

//funciton to lookup data by Link
function lookupByLink (link, table, col, target) {
    if (link.trim().length >= 1) {
        $.post("./php/lookup_by_link.php", {link: link, table: table, col: col}, function (data) {
            $(target).html(data);
        });
    }
}

