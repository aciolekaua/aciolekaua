const express = require('express');
const puppeteer = require('puppeteer');


const server = express();


server.get('/', async (request, response) => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto('https://www.alura.com.br/escola-programacao');
    
    const pageContent = await page.evaluate(() => {
        return {
            subtitle: document.querySelector('.school-text').innerHTML
            // width: document.documentElement.clientWidth,
            // height: document.documentElement.clientHeight,
            // deviceScaleFactor: window.devicePixelRatio
        };
    });


    console.log('pageContent:', pageContent);
    // await page.screenshot({path: 'example.png'});

    //Pegar dados da nota
    await browser.close();  
    response.send(
    {
    "id":113709,
    "code":"front-end",
    "kind":"DEGREE",
    "kindDisplayName":"Formação",
    "kindSlugDisplayName":"formacao",
    "situation":"PUBLISHED",
    "title":"Front-end",
    "subtitle": pageContent.subtitle,
    });
})

const port = 3000
server.listen(port, () => {
    console.log(`Servidor subiu com sucesso acesse em https://localhost:${port}`)
})

//=============================================

// ;(async () => {

// })();