from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from bs4 import BeautifulSoup
import os

# Instantiate options
opts = Options()
# opts.add_argument(" — headless") # Uncomment if the headless version needed
opts.binary_location = "C:\Program Files (x86)\Google\Chrome\Application\chrome.exe"

# Set the location of the webdriver
chrome_driver = "chromedriver.exe"

# Instantiate a webdriver
driver = webdriver.Chrome(options=opts, executable_path=chrome_driver)

# Load the HTML page
driver.get("https://www.pccomponentes.com/buscar/?query=3090&")

# Parse processed webpage with BeautifulSoup
soup = BeautifulSoup(driver.page_source)

for span in soup.select('span:-soup-contains("€")'):    
    try:
        value = span.get_text()
        parsedValue = value.replace('€', '').replace('.', '').replace(',', '.')
        finalPrice = float(parsedValue)
        print(finalPrice)
        break
    except:
        print('JAJANT')
        pass

driver.close()