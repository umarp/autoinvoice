$(document).ready(function () {
    //check All: Event listener for checking/unchecking all checkboxes
    $(document).on("click", "#checkAll", function () {
        $(".itemRow").prop("checked", this.checked);
    });

    // Individual item checkbox clicked
    $(document).on("click", ".itemRow", function () {
        // If all checkboxes are checked, mark "checkAll" checkbox as checked
        if ($(".itemRow:checked").length == $(".itemRow").length) {
            $("#checkAll").prop("checked", true);
        } else {
            $("#checkAll").prop("checked", false);
        }
    });

    // add row: Adding a new row to the table
    var count = $(".itemRow").length;
    $(document).on("click", "#addRows", function () {
        count++; // Increment count for unique IDs
        console.log(count);
        var newRow = "";
        newRow += "<tr>";
        newRow += '<td><input class="itemRow" type="checkbox"></td>'; // Checkbox for the new row
        // Text input for description
        newRow +=
            '<td><input class="form-control" type="text" id="description_' +
            count +
            '" name="description[]"></td>';
        // Input for quantity
        newRow +=
            '<td><input class="form-control quantity" type="number" id="quantity_' +
            count +
            '" name="quantity[]"></td>';
        // Input for unit price
        newRow +=
            '<td><input class="form-control unitPrice" type="number" id="unitPrice_' +
            count +
            '" name="unitPrice[]" step=".01"></td>';
        // Input for total price
        newRow +=
            '<td><input class="form-control totalPrice" type="number" id="totalPrice_' +
            count +
            '" name="totalPrice[]" step=".01"> </td>';
        // Input for remarks
        newRow +=
            '<td><input class="form-control" type="text" id="remarks_' +
            count +
            '" name="remarks[]"> </td>';

        newRow += "</tr>";
        $("#poItems").append(newRow); // Append new row to table
    });

    //Remove Rows: Removing selected rows
    $(document).on("click", "#removeRows", function () {
        console.log("remove");
        $(".itemRow:checked").each(function () {
            $(this).closest("tr").remove();
        });
        $("#checkAll").prop("checked", false); // Uncheck "checkAll" checkbox
        calculateTotal(); // Recalculate total after removing rows
    });
    $(".form").submit(function (event) {
        var rowCount = $("#poItems tbody tr").length;
        if (rowCount === 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please add at least one row in the table.",
            });
            event.preventDefault(); // Prevent form submission if no row is present
        }
    });
});

// Event listener for quantity input blur
$(document).on("blur", "[id^=quantity_]", function () {
    console.log("quantity_");
    calculateTotal(); // Recalculate total after quantity change
});
// Event listener for unit price input blur
$(document).on("blur", "[id^=unitPrice_]", function () {
    console.log("unitPrice_");
    calculateTotal(); // Recalculate total after unit price change
});

// Event listener for excluding VAT
$(document).on("change", "#excludeVat", function () {
    console.log("excludeVat");
    calculateTotal(); // Recalculate total after VAT preference change
});
// Event listener for including VAT
$(document).on("change", "#includeVat", function () {
    console.log("includeVat");
    calculateTotal(); // Recalculate total after VAT preference change
});

//Calculate Total: Function to calculate subtotal, VAT, and total
function calculateTotal() {
    var totalAmount = 0;

    // Loop through each unit price input
    $("[id^='unitPrice_']").each(function () {
        var id = $(this).attr("id");
        id = id.replace("unitPrice_", "");
        var unitPrice = $("#unitPrice_" + id).val(); // Get unit price
        var quantity = $("#quantity_" + id).val(); // Get quantity
        if (!quantity) {
            quantity = 1;
        }
        var total = unitPrice * quantity; // Calculate total for this row
        $("#totalPrice_" + id).val(parseFloat(total)); // Update total price input for this row
        totalAmount += total; // Add to total amount
    });
    $("#subTotal").val(parseFloat(totalAmount.toFixed(2))); // Update subtotal input

    var tax = $("#subTotal").val(); // Get subtotal

    var vatAmount = tax * 0.15; // Calculate VAT amount

    var subTotal = $("#subTotal").val(); // Get subtotal again

    if (document.getElementById("includeVat").checked) {
        var subTotal = $("#subTotal").val(); // Get subtotal

        var total = subTotal * 1.0; // Calculate total including VAT
        var sub = total / 1.15; // Calculate subtotal excluding VAT
        var tax = total - sub; // Calculate VAT amount
        $("#vatAmount").val(tax.toFixed(2)); // Update VAT input
        $("#subTotal").val(sub.toFixed(2)); // Update subtotal input
        $("#total").val(total.toFixed(2)); // Update total input
    } else if (document.getElementById("excludeVat").checked) {
        $("#vatAmount").val(0); // Set VAT amount to 0
        $("#total").val(subTotal); // Update total input
    } else {
        $("#vatAmount").val(vatAmount.toFixed(2)); // Update VAT input
        var vatAmount = subTotal * 0.15; // Recalculate VAT amount
        $("#vatAmount").val(vatAmount.toFixed(2)); // Update VAT input
        subTotal = parseFloat(subTotal) + parseFloat(vatAmount); // Calculate total after adding VAT
        $("#totalAfterTax").val(subTotal.toFixed(2)); // Update total after tax input
        var totalAfterTax = $("#total").val(); // Get total after tax
        $("#total").val(subTotal.toFixed(2)); // Update total input
    }
}
function handleVatChange(checkbox) {
    var excludeCheckbox = document.getElementById("excludeVat");
    var includeCheckbox = document.getElementById("includeVat");

    if (checkbox === excludeCheckbox && excludeCheckbox.checked) {
        includeCheckbox.checked = false;
    } else if (checkbox === includeCheckbox && includeCheckbox.checked) {
        excludeCheckbox.checked = false;
    }
}
