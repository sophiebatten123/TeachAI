<style>
    /* Style for the form */
    form {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    input[type="text"] {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }

    button[type="submit"] {
        padding: 10px 15px;
        background-color: #007bff;
        color: #fff;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<form action="/chat" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="text" name="message" placeholder="Enter your message">
    <button type="submit">Send</button>
</form>

