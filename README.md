# WooCommerce Login & Register With Gmail

1. Create a Google API Project:
    - Go to the Google Developers Console: https://console.developers.google.com/
    - Create a new project and provide a name for it.

2. Enable the Gmail API:

    - In the Google Developers Console, navigate to the "Library" section.
    - Search for "Gmail API" and enable it for your project.

3. Create OAuth Client Credentials:

    - In the Google Developers Console, navigate to the "Credentials" section.
    - Click on "Create Credentials" and select "OAuth client ID."
    - Choose "Web application" as the application type.
    - Enter the authorized JavaScript origins and redirect URIs for your WordPress site.

4. Obtain Client ID and Client Secret:

    - After creating the OAuth client ID, you'll receive a Client ID and Client Secret.
    - Note down these credentials as you'll need them in the next steps.

5. Add Credentials:

    - Go to Settings > Social Login.
    - Add cliend id, client secret, redirect url afte login & save settings.
