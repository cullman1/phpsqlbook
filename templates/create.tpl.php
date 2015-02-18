<div id="main">
    <div>
        <ul>
            <li><a href="messages/">Your inbox</a></a>
        </ul>
    </div>
    <div>
        <h1>Compose message</h1>
            <form action="messages/create" method="post">
                <label for="recipient">To:</label><br />
                <select name="recipient">
                <!-- START recipients -->
                <option value="{ID}" {opt}>{users_name}</option>
                <!-- END recipients -->
                </select><br />
                <label for="subject">Subject:</label><br />
                <input id="subject"
                value="{subject}" /><br />
                <label for="message">Message:</label><br />
                <textarea name="message"></textarea><br />
                <input id="create" value="Send message" />
            </form>
    </div>
</div>