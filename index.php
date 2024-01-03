<?php
echo "<h1 class='top_h1'> Insert New Data
<form method='POST' action='insert.php'>

<div>
<label> Title </label>
   <input type='text' name='title' required /> 
</div>

<div>
<label> Price </label>
   <input type='number' name='price' required /> 
</div>

<div>
<input type='submit' value='Insert New Data' />
</div>

</form>
</h1>";

echo "<div class='search_div'>
    <form method='GET' id='searchForm'>
        <div>
            <label>Title</label>
            <input type='text' name='title' placeholder='Enter Title' />
        </div>

        <div>
            <label>Price</label>
            <input type='text' name='price' placeholder='Enter Price' />
        </div>

        <button type='submit' name='search'>Search</button>

    </form>
</div>";
?>
<div id="response_div"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function loadData(page) {
        $.ajax({
            url: "selection_process.php?page=" + page,
            type: "GET",
            success: function(response) {
                console.log(response);
                $("#response_div").html(response);
            }
        });
    }

    $("#searchForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "selection_process.php",
            type: "GET",
            data: $(this).serialize(),
            success: function(response) {
                $("#response_div").html(response);
            },
            error: function() {
                alert("ERROR By AJAX in Search System");
            }
        })
    })


    $(document).on("click", ".pagination-link", function(e) {
        e.preventDefault();

        var page = $(this).data('page');
        loadData(page);
    })

    loadData(1);
</script>