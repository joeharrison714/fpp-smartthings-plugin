# fpp-smartthings

This is a Falcon Player (fpp) plugin that allows you to control SmartThings devices or run routines by using commands in fpp.

NOTE: This currently uses the SmartThings groovy IDE, which is said to be going away sometime in 2021. When that happens this plugin will need to be updated.

## Installation
In fpp, go to Content Setup, Plugin Manager and paste the following URL in the box and click "Retrieve Plugin Info":
`https://raw.githubusercontent.com/joeharrison714/fpp-smartthings-plugin/master/pluginInfo.json`

## Setup
### Install SmartApp
1. Login to https://graph.api.smartthings.com/ide/apps
1. Click `New SmartApp` and then `From Code`
1. Copy and paste the contents of this file into the text box:
   `https://raw.githubusercontent.com/joeharrison714/fpp-smartthings-app/master/smartapps/fpp-smartthings/fpp-web-services.src/fpp-web-services.groovy`
1. Click Save
1. Click Publish -> For Me
1. Edit the SmartApp
1. Under OAuth click "Enable OAuth in Smart App"
1. Leave defaults and click update
1. Copy the client ID and client Secret for use in the next step

### Setup plugin
1. In the plugin configuration, paste the client ID and secret that you copied above.
1. Move away from the text box for the value to save
1. Click the link that should appear titled "Configure SmartThings Access"
1. Login with SmartThings and choose which switches you want FPP to be able to control
1. Click Authorize
1. After returning to FPP, restart FPPD
1. Test control of your devices/routines using the buttons on the plugin configuration page
1. The SmartThings commands should now be available in FPP