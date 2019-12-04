import unittest
from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.by import By
import time

class HomePageTest(unittest.TestCase):
	@classmethod
	def setUp(inst):
		# create a new Chrome session """
		inst.driver = webdriver.Chrome()
		inst.driver.implicitly_wait(5)
		inst.driver.maximize_window()

		# navigate to the application login page """
		inst.driver.get("http://localhost/450project/login.php")

	def test_email_input(self):
		# check email input exists on login page
		time.sleep(2)
		self.assertTrue(self.is_element_present(By.NAME,"email"))

	def test_password_input(self):
		# check search box exists on login page
		time.sleep(2)
		self.assertTrue(self.is_element_present(By.NAME,"password"))


	def test_login(self):
		# check login

		
		self.username = self.driver.find_element_by_name("email")
		self.password = self.driver.find_element_by_name("password")
		
		self.username.send_keys("dooleytucker@gmail.com")
		self.password.send_keys("adminadmin")
		
		self.search_field = self.driver.find_element_by_name("login")
		time.sleep(2)
		self.search_field.click()
		
		time.sleep(2)
		print(self.driver.title)
		self.assertTrue("Impact: Dashboard" in self.driver.title)

	@classmethod
	def tearDown(inst):
		# close the browser window
		inst.driver.quit()

	def is_element_present(self, how, what):
		"""
		Helper method to confirm the presence of an element on page
		:params how: By locator type
		:params what: locator value
		"""
		try: self.driver.find_element(by=how, value=what)
		except NoSuchElementException: return False
		return True

if __name__ == '__main__':
	unittest.main(verbosity=2)

	
'''
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import time
import unittest

driver = webdriver.Chrome()

driver.get("http://localhost/450project/login.php")
assert "Impact: Log In" in driver.title

username = driver.find_element_by_name("email")
username.send_keys("dooleytucker@gmail.com")
password = driver.find_element_by_name("password")
password.send_keys("adminadmin")

webdriver.ActionChains(driver).send_keys(u'\ue007').perform()#enter

time.sleep(3)
assert "Impact: Dashboard" in driver.title
time.sleep(2)

driver.get("http://localhost/450project/login.php")
assert "Impact: Dashboard" in driver.title


#webdriver.ActionChains(driver).send_keys(u'\ue004').perform()#tab
#webdriver.ActionChains(driver).send_keys(u'\ue004').perform()#tab
#webdriver.ActionChains(driver).send_keys(u'\ue007').perform()#enter


		
#temp = driver.find_element_by_class_name("playback-bar__progress-time")#get current time
#cur = temp.text

#temp = driver.find_element_by_xpath("(//div[@class='playback-bar__progress-time'])[2]")#get song length
#dur = temp.text

		
		
driver.close()
'''
