$(document).ready(function () {
    console.log("good");
    //check All
    $(document).on("click", "#checkAll", function () {
        $(".itemRow").prop("checked", this.checked);
    });

    $(document).on("click", ".itemRow", function () {
        if ($(".itemRow:checked").length == $(".itemRow").length) {
            $("#checkAll").prop("checked", true);
        } else {
            $("#checkAll").prop("checked", false);
        }
    });

    // add row
    var count = $(".itemRow").length;
    $(document).on("click", "#addRows", function () {
        count++;
        console.log(count);
        var newRow = "";
        newRow += "<tr>";
        newRow += '<td><input class="itemRow" type="checkbox"></td>';
        newRow +=
            '<td><input class="form-control" type="text" id="description_' +
            count +
            '" name="description[]"></td>';
        newRow +=
            '<td><input class="form-control quantity" type="number" id="quantity_' +
            count +
            '" name="quantity[]"></td>';
        newRow +=
            '<td><input class="form-control unitPrice" type="number" id="unitPrice_' +
            count +
            '" name="unitPrice[]" step=".01"></td>';

        newRow +=
            '<td><input class="form-control totalPrice" type="number" id="totalPrice_' +
            count +
            '" name="totalPrice[]" step=".01"> </td>';

        newRow +=
            '<td><input class="form-control" type="text" id="remarks_' +
            count +
            '" name="remarks[]"> </td>';

        newRow += "</tr>";
        $("#poItems").append(newRow);
    });

    //Remove Rows
    $(document).on("click", "#removeRows", function () {
        $(".itemRow:checked").each(function () {
            $(this).closest("tr").removed;
        });
        $("#checkAll").prop("checked", false);
        calculateTotal();
    });
});

$(document).on("blur", "[id^=quantity_]", function () {
    console.log("quantity_");
    calculateTotal();
});
$(document).on("blur", "[id^=unitPrice_]", function () {
    console.log("unitPrice_");
    calculateTotal();
});

$(document).on("blur", "#excludeVat", function () {
    console.log("excludeVat");
    calculateTotal();
});
$(document).on("blur", "#includeVat", function () {
    console.log("includeVat");
    calculateTotal();
});

//Calculate Total
function calculateTotal() {
    var totalAmount = 0;

    $("[id^='unitPrice_']").each(function () {
        var id = $(this).attr("id");
        id = id.replace("unitPrice_", "");
        var unitPrice = $("#unitPrice_" + id).val();
        var quantity = $("#quantity_" + id).val();
        if (!quantity) {
            quantity = 1;
        }
        var total = unitPrice * quantity;
        $("#totalPrice_" + id).val(parseFloat(total));
        totalAmount += total;
    });
    $("#subTotal").val(parseFloat(totalAmount.toFixed(2)));
    var tax = $("#subTotal").val();

    vatAmount = tax * 0.15;
    var subTotal = $("#subTotal").val();

    if (document.getElementById("includeVat").checked) {
        var subTotal = $("#subTotal").val();

        var total = subTotal * 1.0;
        var sub = total / 1.15;
        var tax = total - sub;
        $("#vatAmount").val(tax.toFixed(2));
        $("#subTotal").val(sub.toFixed(2));
        $("#total").val(total.toFixed(2));
    } else if (document.getElementById("excludeVat").checked) {
        $("#vatAmount").val(0);
        $("#total").val(subTotal);
    } else {
        $("#vatAmount").val(vatAmount.toFixed(2));
        var vatAmount = subTotal * 0.15;
        $("#vatAmount").val(vatAmount.toFixed(2));
        subTotal = parseFloat(subTotal) + parseFloat(vatAmount);
        $("#totalAfterTax").val(subTotal.toFixed(2));
        var totalAfterTax = $("#total").val();
        $("#total").val(subTotal.toFixed(2));
    }
}
