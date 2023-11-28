$(document).ready(function(){
    // $("#order").keyup(function(){//search filter in pendingorders by order no
    //     // var order=$(this).val();
    //     searchbyOrderno();
    //     // console.log(order);
    // });

    // $("#det").keyup(function(){//search filter in pendingorders by details
    //     // var det=$(this).val();
    //     searchbyDetails();
    //     // console.log(order);
    // });

    // function searchbyOrderno() {//search filter in pendingorders by order no
    //     var input, filter, table, tr, td, i, txtValue;
    //     input = document.getElementById("order");
    //     filter = input.value.toUpperCase();
    //     table = document.getElementById("pendingTable");
    //     tr = table.getElementsByTagName("tr");
    //     for (i = 0; i < tr.length; i++) {
    //         td = tr[i].getElementsByTagName("td")[0];
    //         if(td)
    //         {
    //             txtValue = td.textContent || td.innerText;
    //             if(txtValue.toUpperCase().indexOf(filter) > -1)
    //             {
    //                 tr[i].style.display = "";
    //             }
    //             else
    //             {
    //                 tr[i].style.display = "none";
    //             }
    //         }
    //     }
    // }

    // function searchbyDetails() {//search filter in pendingorders by details
    //     var input, filter, table, tr, td, i, txtValue;
    //     input = document.getElementById("det");
    //     filter = input.value.toUpperCase();
    //     table = document.getElementById("pendingTable");
    //     tr = table.getElementsByTagName("tr");
    //     for (i = 0; i < tr.length; i++) {
    //         td = tr[i].getElementsByTagName("td")[1];
    //         if(td)
    //         {
    //             txtValue = td.textContent || td.innerText;
    //             if(txtValue.toUpperCase().indexOf(filter) > -1)
    //             {
    //                 tr[i].style.display = "";
    //             }
    //             else
    //             {
    //                 tr[i].style.display = "none";
    //             }
    //         }
    //     }
    // }

    // $("#det").keyup(function(){//search filter in pendingorders by details
    //     // var det=$(this).val();
    //     searchbyDetails();
    //     // console.log(order);
    // });
    setInterval(displayHello,100);
    function displayHello()
    {
        var a=$(".jplist-current").first().text();
        // console.log(a);
        // $(".jplist-label").text("Page "+a+" of");

        var srchcase=$("#srchcase").val();
        var srchplnf=$("#srchplnf").val();
        if(srchcase!="" || srchplnf!="")
        $(".jplist-label").hide();
        else{
            $(".jplist-label").show();
        }
        // console.log(srchcase);
        var b=$(".jplist-dd-panel").first().text();
        b=b.slice(1, 3);
        if(b==10)
        $(".jplist-label").text("Page "+a+" of 10");
        else if(b==5)
        $(".jplist-label").text("Page "+a+" of 20");
        else if(b==3)
        $(".jplist-label").text("Page "+a+" of 34");
        
    }

});