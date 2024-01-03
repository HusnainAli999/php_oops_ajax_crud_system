<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    table {
        width: 100%;
    }

    table tr th {
        background: black;
        color: white;
        padding: 10px;
    }

    table tr td {
        padding: 10px;
        background: rgb(29, 92, 29);
        color: white;
    }

    table tr td .delete_a {
        background: red;
        color: white;
        padding: 10px;
        text-decoration: none;
        outline: none;
    }

    table tr td form button[type='submit'] {
        background: green;
        color: white;
        padding: 10px;
        border-radius: 2px;
        text-decoration: none;
        border: none;
        outline: none;
        cursor: pointer;
    }

    .alert_h1 {
        background: black;
        color: white;
        padding: 20px;
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border-radius: 3px;
        cursor: pointer;
        z-index: 9999;
    }

    .top_h1 {
        background: black;
        color: white;
        padding: 20px;
    }

    .top_h1 form {
        width: 100%;
        font-size: 20px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        color: white;
        padding-top: 20px;
    }

    .top_h1 form input {
        padding: 8px;
        background: gray;
        border: none;
        outline: none;
        color: white;
        border-radius: 3px;
    }

    .top_h1 form input[type="submit"] {
        background: green;
        color: white;
        padding: 10px;
        width: 150px;
        border: none;
        outline: none;
        border-radius: 3px;
        cursor: pointer;
    }

    #update_form {
        width: 500px;
        background: white;
        color: black;
        padding: 20px;
        border-radius: 7px;
        box-shadow: 10px 10px 30px gray;
        position: relative;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    #update_form label {
        display: inline-block;
        padding: 10px 10px 10px 0px;
    }

    #update_form input {
        padding: 5px;
        width: 250px;
    }

    #update_form button {
        background: green;
        color: white;
        border-radius: 3px;
        border: none;
        outline: none;
        cursor: pointer;
        width: 200px;
        padding: 10px;
        margin-top: 20px;
    }

    .pagination_a {
        background: black;
        color: white;
        cursor: pointer;
        padding: 10px;
        border-radius: 3px;
        text-decoration: none;
        position: relative;
        top: 30px;
        left: 10px;
    }

    .active {
        background: green;
    }

    .last_pagination_a {
        background: darkgreen;
        color: white;
        cursor: pointer;
        border-radius: 3px;
        padding: 10px;
        text-decoration: none;
        position: relative;
        top: 30px;
        left: 10px;
    }

    .first_pagination_a {
        background: darkgreen;
        color: white;
        cursor: pointer;
        border-radius: 3px;
        padding: 10px;
        text-decoration: none;
        position: relative;
        top: 30px;
        left: 5px;
    }

    .next_pagination_a {
        background: rgb(29, 92, 29);
        color: white;
        cursor: pointer;
        border-radius: 3px;
        padding: 10px;
        text-decoration: none;
        position: relative;
        top: 30px;
        left: 15px;
    }

    .main_pagination_div {
        position: relative;
    }

    .previous_pagination_a {
        background: rgb(29, 92, 29);
        color: white;
        cursor: pointer;
        border-radius: 3px;
        padding: 10px;
        text-decoration: none;
        position: relative;
        top: 30px;
        left: 7px;
    }

    .ellipses {
        position: relative;
        top: 30px;
        font-size: 20px;
        left: 10px;
    }

    .search_div {
        height: 80px;
        padding: 20px;
    }

    #searchForm {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        flex-wrap: wrap;
    }

    .search_div label {
        display: inline-block;
        font-size: 20px;
    }

    .search_div input {
        width: 200px;
        background: green;
        color: white;
        padding: 10px;
        border: none;
        outline: none;
    }

    .search_div input::placeholder {
        color: white;
    }

    .search_div button {
        width: 200px;
        color: white;
        padding: 10px;
        background: green;
        border: none;
        cursor: pointer;
    }
</style>