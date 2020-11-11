<h1>SmartThings for FPP</h1>

<p><strong>NOTE:</strong> This currently uses the SmartThings groovy IDE, which is said to be going away sometime in 2021. When that happens this plugin will need to be updated.
</p>

<h2>How to set up:</h2>
<ol>
    <li>Install SmartApp</li>
        <ol>
            <li>Login to https://graph.api.smartthings.com/ide/apps</li>
            <li>Click `New SmartApp` and then `From Code`</li>
            <li>Copy and paste the contents of this file into the text box:<br />https://raw.githubusercontent.com/joeharrison714/fpp-smartthings-app/master/smartapps/fpp-smartthings/fpp-web-services.src/fpp-web-services.groovy</li>
            <li>Click Save</li>
            <li>Click Publish -> For Me</li>
            <li>Edit the SmartApp</li>
            <li>Under OAuth click "Enable OAuth in Smart App"</li>
            <li>Leave defaults and click update</li>
            <li>Copy the client ID and client Secret for use in the next step</li>
        </ol>
    <li>Setup plugin</li>
        <ol>
            <li>In the plugin configuration, paste the client ID and secret that you copied above.</li>
            <li>Move away from the text box for the value to save</li>
            <li>Click the link that should appear titled "Configure SmartThings Access"</li>
            <li>Login with SmartThings and choose which switches you want FPP to be able to control</li>
            <li>Click Authorize</li>
            <li>After returning to FPP, restart FPPD</li>
            <li>Test control of your devices/routines using the buttons on the plugin configuration page</li>
            <li>The SmartThings commands should now be available in FPP</li>
        </ol>
</ol>