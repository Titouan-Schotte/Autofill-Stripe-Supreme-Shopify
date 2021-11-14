# What is an autofill?
An autofill is a small extension on your browser that allows you to automatically fill out a payment form on sites.
This autofill that I offer is at the origin of a paid order and is suitable for the following sites:
- Stripe
- All sites created with Shopify
- Supreme

![Autofill Presentation](https://i.ibb.co/jfsvqmZ/image.png)

![Autofill Settings](https://i.ibb.co/nr76sS7/image.png)
# How it works ?

## Discord Bot
Originally this product was chargeable and you are free to make it chargeable!
The payment system was made by paying access to a Discord server using Stripe which offers this type of service.
You need a discord bot on your discord server that logs in as new ones arrive on your server. So your bot contains a small .txt file with all the identifiers of the people authorized to use the autofill.

So you must host the bot contained in the folder named "**BOTDISCORD**"

-> Copy the entire folder

-> Put a discord bot token in the `config.json` file

-> Type the command `node index` in a terminal


## WebSite

Following this, you will need web hosting to manage the connection between your discord bot and your chrome extension (autofill).
Indeed, once the discord bot has recorded the discord account in its .txt file, you must now verify that a user of your autofill is listed in the autofill!
So we need a website that manages the bridge between discord and your autofill.

The site that I propose to you in the "**SITEAUTH**" folder offers a new user of your autofill to connect to his discord account to check if he is one of the people registered in the .txt file of the discord bot.

You will therefore need web hosting and a domain name.

## Autofill

Once you have completed the two steps above, you've done the hard part!
You will now need to modify a few short lines of code to replace the base domain name with the domain name of your site.

-> At line 62 of the `manifest.json` with your domain website.

-> At line 17 of the `popup/popup.js` with your domain website.

And it should work perfectly!
![Auth button](https://i.ibb.co/27R65VR/image.png)
If you have any questions about how it works, don't hesitate.
