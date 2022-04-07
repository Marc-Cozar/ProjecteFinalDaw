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
mycursor2.execute("SELECT name FROM webs")
web = mycursor2.fetchall()

# Instantiate options
opts = Options()
# opts.add_argument("--headless")
opts.binary_location = "C:\Program Files (x86)\Google\Chrome\Application\chrome.exe"

# Set the location of the webdriver
chrome_driver = "chromedriver.exe"

for x in products:
    # Instantiate a webdriver
    driver = webdriver.Chrome(options=opts, executable_path=chrome_driver)

    # Load the HTML page
    driver.get("https://www.pccomponentes.com/buscar/?query=" + x[0])

    # Parse processed webpage with BeautifulSoup
    soup = BeautifulSoup(driver.page_source)

    for span in soup.select('span:-soup-contains("€")'):    
        try:
            value = span.get_text()
            parsedValue = value.replace('€', '').replace('.', '').replace(',', '.')
            finalPrice = float(parsedValue)

            resp = requests.post('http://127.0.0.1:8000/api/set-price', {'id': x[1], 'price': finalPrice})
            break
        except:
            pass

    driver.close()
    time.sleep(1)
