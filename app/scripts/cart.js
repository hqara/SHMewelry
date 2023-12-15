$(document).ready(function () 
{
    calcTotal();
    // Select all button elements whose id attribute starts with "remove"
    $('button[name^="remove"]').click(function() {
        var buttonId = $(this).attr('name'); // Get the full id name
    
        // Extract the numeric part of the id
        var itemId = buttonId.replace('remove', '');
        var trId = "#product" + itemId;
    
        $.ajax({
            type: 'GET',
            url: 'index.php?controller=user&action=unbag',
            data: {
                product_id: itemId
            },
            success: function(response) {
                // removes the row 
                $(trId).remove();

                if ($('button[id^="remove"]').length < 1)
                {
                    // shows there are no elements in the cart
                    $(".table").replaceWith(`
                        <center>
                        <table style="background-color: #e6f3f8; width: 100%; height: auto; margin-bottom:50px;">
                            <tr>
                                <td style="padding:25px">
                                    <h5 style="text-align:center;">You have no items in the cart.</h5>
                                </td>
                            </tr>
                        </table>
                        </center>
                    `);
                }
                calcTotal();
                console.log("item " + itemId + " successfully removed from your cart!");
            }
        });
    });

    // $('input[id^="quantity"]').change(
    $('[id^="btnUp"], [id^="btnDown"]').click(function() {
        
        var thisID = $(this).attr('id'); // Get the full id name
    
        // Extract the numeric part of the id
        var product_id = (thisID.match(/(\d+)/))[0];
        // getting the quantity
        var qty = $("#quantity" + product_id).val();

        $.ajax({
            type: 'GET',
            url: 'index.php?controller=user&action=updateQty',
            data: {
                product_id: product_id,
                qty: qty
            },
            success: function(response) {
                calcTotal();
                // change the single product running total to the price (in a hidden tag) times the quantity
                $("#runningPriceProduct"+product_id).html("$" + (Number($("#fullPriceProduct"+product_id).html()) * qty).toFixed(2));
                console.log("item " + product_id + " successfully updated!");
            }
        });
    });

    // clearing the cart
    $('button[id=clear]').click(function() {

        $.ajax({
            type: 'GET',
            url: 'index.php?controller=user&action=unbagAll',
            data: {
            },
            success: function(response) {
                $(".table").replaceWith(`
                        <center>
                        <table style="background-color: #e6f3f8; width: 100%; height: auto; margin-bottom:50px;">
                            <tr>
                                <td style="padding:25px">
                                    <h5 style="text-align:center;">You have no items in the cart.</h5>
                                </td>
                            </tr>
                        </table>
                        </center>
                    `);
                calcTotal();
                console.log("All items successfully cleared!");
            }
        });
    });
});

function calcTotal()
{
    var totalTag = $("h4[id=totalLabel]");
    var hiddenTotal = $("p[id=total]");
    var total = 0;

    $('[id^="runningPriceProduct"]').each(function() {
        var thisTotal = Number(($(this).html()).substring(1));
        total += thisTotal;
    });

    hiddenTotal.html(total); // the hidden total holds the actual value
    totalTag.html("Total: $" + total.toFixed(2)); // the total tag displays the value
    console.log(total);
}


