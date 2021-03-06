from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from bs4 import BeautifulSoup
import mysql.connector
import requests
import os
import time

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="laravel"
)

mycursor = mydb.cursor()
mycursor.execute("SELECT name, id FROM products")
products = mycursor.fetchall()

mycursor2 = mydb.cursor()
mycursor2.execute("SELECT name, url, id FROM webs")
webs = mycursor2.fetchall()

# Instantiate options
opts = Options()
# opts.add_argument("--headless")
opts.add_argument('--log-level=1')
opts.binary_location = "C:\Program Files\Google\Chrome\Application\chrome.exe"

# Set the location of the webdriver
chrome_driver = "chromedriver_101.exe"

def getScraping(web, product):
    try:
        # Instantiate a webdriver
        driver = webdriver.Chrome(options=opts, executable_path=chrome_driver)

        # Load the HTML page
        driver.get(web[1] + product[0])

        # Parse processed webpage with BeautifulSoup
        soup = BeautifulSoup(driver.page_source, "html.parser")

        if "PcComponentes" in web[0]:
            for price in soup.select('span:-soup-contains("€")'):    
                try:
                    savePrice(price, product, web)
                    break
                except Exception as e:
                    print(e)
                    pass
        elif "CoolMod" in web[0]:
            for price in soup.select_one('.df-card__price'):    
                try:
                    savePrice(price, product, web)
                    break
                except Exception as e:
                    print(e)
                    pass
        elif "Amazon" in web[0]:
            for price in soup.select_one('.a-price-whole'):    
                try:
                    savePrice(price, product, web)
                    break
                except Exception as e:
                    print(e)
                    pass
        elif "BackMarket" in web[0]:
            for price in soup.select_one('.body-2-bold.text-black'):    
                try:
                    savePrice(price, product, web)
                    break
                except Exception as e:
                    print(e)
                    pass

        driver.close()
        time.sleep(1)
    except Exception as e:
        print(e)
        pass

def savePrice(price, product, web):
    value = price.get_text()
    parsedValue = value.replace('€', '').replace('.', '').replace(',', '.')
    finalPrice = float(parsedValue)
    resp = requests.post('http://127.0.0.1:8000/api/set-price', {'id': product[1], 'price': finalPrice, 'web_id': web[2]})
    
for x in products:
    for web in webs:
        getScraping(web, x)
    
