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

	
	def test_login(self):
		# check login
		time.sleep(2)
		print("Email Field")
		self.assertTrue(self.is_element_present(By.NAME,"email"))
		print("Pass")
		print("PAssword Field")
		self.assertTrue(self.is_element_present(By.NAME,"password"))
		print("Pass")
		self.username = self.driver.find_element_by_name("email")
		self.password = self.driver.find_element_by_name("password")
		
		self.username.send_keys("dooleytucker@gmail.com")
		self.password.send_keys("adminadmin")
		
		self.search_field = self.driver.find_element_by_name("login")
		time.sleep(2)
		self.search_field.click()
		
		time.sleep(2)
		print("On Dashboard")
		self.assertTrue("Impact: Dashboard" in self.driver.title)
		print("Pass")
		
		
	def test_member_register_and_delete(self):
	
	
		self.username = self.driver.find_element_by_name("email")
		self.password = self.driver.find_element_by_name("password")
		
		self.username.send_keys("dooleytucker@gmail.com")
		self.password.send_keys("adminadmin")
		
		self.search_field = self.driver.find_element_by_name("login")
		time.sleep(2)
		self.search_field.click()
		
		time.sleep(2)
		print("On Dashboard")
		self.assertTrue("Impact: Dashboard" in self.driver.title)
		print("Pass")
	
		time.sleep(2)
	
		
		self.driver.get("http://localhost/450project/register.php")
		time.sleep(2)
		self.email = self.driver.find_element_by_name("email")
		self.first_name = self.driver.find_element_by_name("first_name")
		self.last_name = self.driver.find_element_by_name("last_name")
		self.home_address = self.driver.find_element_by_name("home_address")
		self.phone_number = self.driver.find_element_by_name("phone_number")
		self.major = self.driver.find_element_by_name("major")
		self.prayer_request = self.driver.find_element_by_name("prayer_request")
		
		self.email.send_keys("test@gmail.com")
		self.first_name.send_keys("testy")
		self.last_name.send_keys("tester")
		self.home_address.send_keys("testy tester dr.")
		self.phone_number.send_keys("3171234567")
		self.major.send_keys("CS")
		self.prayer_request.send_keys("food")
		
		
		self.button = self.driver.find_element_by_tag_name("button")
		time.sleep(2)
		self.button.click()
		
		time.sleep(2)
		print("On member management page")
		self.assertTrue("Impact:" in self.driver.title)
		print("Pass")
		self.member = self.driver.find_element_by_class_name("sorting_1")
		print("Member Exists")
		self.assertTrue(self.member.text == "testy")
		print("Pass")
		
		self.button = self.driver.find_element_by_name("deletemember")
		time.sleep(2)
		self.button.submit()
		time.sleep(2)
		print("Delete member")
		self.assertFalse(self.is_element_present(By.CLASS_NAME,"sorting_1"))
		print("Pass")
		
	
	def test_member_checkin(self):
		self.username = self.driver.find_element_by_name("email")
		self.password = self.driver.find_element_by_name("password")
		
		self.username.send_keys("dooleytucker@gmail.com")
		self.password.send_keys("adminadmin")
		
		self.search_field = self.driver.find_element_by_name("login")
		time.sleep(2)
		self.search_field.click()
		
		time.sleep(2)
		print("On Dashboard")
		self.assertTrue("Impact: Dashboard" in self.driver.title)
		print("Pass")
	
		time.sleep(2)
	
		
		self.driver.get("http://localhost/450project/register.php")
		time.sleep(2)
		self.email = self.driver.find_element_by_name("email")
		self.first_name = self.driver.find_element_by_name("first_name")
		self.last_name = self.driver.find_element_by_name("last_name")
		self.home_address = self.driver.find_element_by_name("home_address")
		self.phone_number = self.driver.find_element_by_name("phone_number")
		self.major = self.driver.find_element_by_name("major")
		self.prayer_request = self.driver.find_element_by_name("prayer_request")
		
		self.email.send_keys("test@gmail.com")
		self.first_name.send_keys("testy")
		self.last_name.send_keys("tester")
		self.home_address.send_keys("testy tester dr.")
		self.phone_number.send_keys("3171234567")
		self.major.send_keys("CS")
		self.prayer_request.send_keys("food")
		
		
		self.button = self.driver.find_element_by_tag_name("button")
		time.sleep(2)
		self.button.click()
		
		time.sleep(2)
		print("On member management page")
		self.assertTrue("Impact:" in self.driver.title)
		print("Pass")
		self.member = self.driver.find_element_by_class_name("sorting_1")
		print("Member Exists")
		self.assertTrue(self.member.text == "testy")
		print("Pass")
		
		self.driver.get("http://localhost/450project/preCheckin.php")
		time.sleep(2)
		
		print("On member pre checkin page")
		self.assertTrue("Impact:" in self.driver.title)
		print("Pass")
		
		
		self.date = self.driver.find_element_by_name("nowdate")
		
		self.date.send_keys("12032019")
		self.button = self.driver.find_element_by_name("submitBtn")
		self.button.click()
		
		time.sleep(2)
		
		print("On member Checkin page")
		self.assertTrue("Impact: Check In" in self.driver.title)
		print("Pass")
		
		self.phone = self.driver.find_element_by_name("phone")
		self.phone.send_keys("3171234567")
		
		self.button = self.driver.find_element_by_id("checkIn")
		self.button.click()
		
		time.sleep(2)
		
		self.name = self.driver.find_element_by_id("name")
		
		print("Is Member There")
		print(self.name.text)
		self.assertTrue(self.name.text == "testy tester")
		print("Pass")
		
		self.button = self.driver.find_element_by_id("confirmInfo")
		self.button.click()
		
		time.sleep(2)
		
		self.button = self.driver.find_element_by_id("noThanks")
		self.button.click()
		
		time.sleep(2)
		
		self.button = self.driver.find_element_by_id("finishPrayer")
		self.button.click()
		
		time.sleep(4)
		
		print("On member Checkin page")
		self.assertTrue("Impact: Check In" in self.driver.title)
		print("Pass")
		
		
		self.driver.get("http://localhost/450project/logout.php")
		time.sleep(2)
		
		print("On member Login page")
		self.assertTrue("Impact: Log In" in self.driver.title)
		print("Pass")
		
		
		
		
		
		
		self.username = self.driver.find_element_by_name("email")
		self.password = self.driver.find_element_by_name("password")
		
		self.username.send_keys("dooleytucker@gmail.com")
		self.password.send_keys("adminadmin")
		
		self.search_field = self.driver.find_element_by_name("login")
		time.sleep(2)
		self.search_field.click()
		
		time.sleep(2)
		print("On Dashboard")
		self.assertTrue("Impact: Dashboard" in self.driver.title)
		print("Pass")
	
		time.sleep(2)
	
		self.driver.get("http://localhost/450project/member_management.php")
		time.sleep(2)
		print("On member management page")
		self.assertTrue("Impact:" in self.driver.title)
		print("Pass")
		self.member = self.driver.find_element_by_class_name("sorting_1")
		print("Member Exists")
		self.assertTrue(self.member.text == "testy")
		print("Pass")
		
		self.button = self.driver.find_element_by_name("deletemember")
		time.sleep(2)
		self.button.submit()
		time.sleep(2)
		print("Delete member")
		self.assertFalse(self.is_element_present(By.CLASS_NAME,"sorting_1"))
		print("Pass")	
	
	def test_member_edit(self):
		
		
		
		self.username = self.driver.find_element_by_name("email")
		self.password = self.driver.find_element_by_name("password")
		
		self.username.send_keys("dooleytucker@gmail.com")
		self.password.send_keys("adminadmin")
		
		self.search_field = self.driver.find_element_by_name("login")
		time.sleep(2)
		self.search_field.click()
		
		time.sleep(2)
		print("On Dashboard")
		self.assertTrue("Impact: Dashboard" in self.driver.title)
		print("Pass")
	
		time.sleep(2)
	
		
		self.driver.get("http://localhost/450project/register.php")
		time.sleep(2)
		self.email = self.driver.find_element_by_name("email")
		self.first_name = self.driver.find_element_by_name("first_name")
		self.last_name = self.driver.find_element_by_name("last_name")
		self.home_address = self.driver.find_element_by_name("home_address")
		self.phone_number = self.driver.find_element_by_name("phone_number")
		self.major = self.driver.find_element_by_name("major")
		self.prayer_request = self.driver.find_element_by_name("prayer_request")
		
		self.email.send_keys("test@gmail.com")
		self.first_name.send_keys("testy")
		self.last_name.send_keys("tester")
		self.home_address.send_keys("testy tester dr.")
		self.phone_number.send_keys("3171234567")
		self.major.send_keys("CS")
		self.prayer_request.send_keys("food")
		
		
		self.button = self.driver.find_element_by_tag_name("button")
		time.sleep(2)
		self.button.click()
		
		time.sleep(2)
		print("On member management page")
		self.assertTrue("Impact:" in self.driver.title)
		print("Pass")
		self.member = self.driver.find_element_by_class_name("sorting_1")
		print("Member Exists")
		self.assertTrue(self.member.text == "testy")
		print("Pass")
		
		
		
		
		
		
		
		
		self.driver.find_element_by_name("editmember").submit()

		self.driver.find_element_by_id("email").clear()
		self.driver.find_element_by_id("email").send_keys("newEmail@yahoo.com")
		self.driver.find_element_by_id("first_name").clear()
		self.driver.find_element_by_id("first_name").send_keys("Keith")
		self.driver.find_element_by_id("last_name").clear()
		self.driver.find_element_by_id("last_name").send_keys("Urban")
		self.driver.find_element_by_id("phone_number").clear()
		self.driver.find_element_by_id("phone_number").send_keys("3175551234")
		self.driver.find_element_by_id("major").clear()
		self.driver.find_element_by_id("major").send_keys("History")
		self.driver.find_element_by_id("home_address").clear()
		self.driver.find_element_by_id("home_address").send_keys("123 Bay Ln")
		self.driver.find_element_by_id("prayer_request").clear()
		self.driver.find_element_by_id("prayer_request").send_keys("Our Father")
		self.driver.find_element_by_id("prayer_request").submit()
		
		time.sleep(2)
		
		
		self.member = self.driver.find_element_by_class_name("sorting_1")
		
		print("Member changed")
		self.assertTrue(self.member.text == "Keith")
		print("Pass")
		
		
		
		
		self.button = self.driver.find_element_by_name("deletemember")
		time.sleep(2)
		self.button.submit()
		time.sleep(2)
		print("Delete member")
		self.assertFalse(self.is_element_present(By.CLASS_NAME,"sorting_1"))
		print("Pass")
		
		
		
		
		
		
		
		
		
	
	
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
