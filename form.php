<div class="container" style="margin-top:30px">

	<div class="row mt-2">
		<div class="col">
				<a href="member_management.php">
					<button type="submit" class="btn btn-secondary">Back</button>
				</a>
		</div>
	</div>


	<div class="row">
		<div class="col">
			<form action="" method="post" class="needs-validation" novalidate>
			  <div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email" value="<?php echo $Email; ?>" placeholder="Enter email" name="email" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $email_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="first_name">First Name:</label>
				<input type="text" class="form-control" id="first_name" value="<?php echo $FirstName; ?>" placeholder="Enter first name" name="first_name" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $first_name_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="last_name">Last Name:</label>
				<input type="text" class="form-control" id="last_name" value="<?php echo $LastName; ?>" placeholder="Enter last name" name="last_name" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $last_name_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="phone_number">Phone Number:</label>
				<input type="text" class="form-control" id="phone_number" value="<?php echo $PhoneNumber; ?>" placeholder="Enter phone number" name="phone_number" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $phone_number_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="major">Major:</label>
				<input type="text" class="form-control" id="major" value="<?php echo $Major; ?>" placeholder="Enter major" name="major" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $major_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="graduation_date">Graduation Date:</label>
				<input type="text" class="form-control" id="graduation_date" value="<?php echo $GraduationDate; ?>" placeholder="Enter graduation date" name="graduation_date" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $graduation_date_error; ?></span>
			  </div>
			  

			  <div class="form-group">
				<label for="group_id">Group:</label>
					<select name="group_id" class="custom-select">						
						<?php
						$GroupIDStmt = $con->prepare("SELECT * FROM groups");
						$GroupIDStmt->execute(array());
						while($GroupRow = $GroupIDStmt->fetch(PDO::FETCH_ASSOC)) {
							$isSelected = "";
							if($GroupRow['GroupID'] == $GroupID){
								$isSelected = "selected";
							}
							echo "<option value=".$GroupRow['GroupID']." $isSelected>".$GroupRow['GroupName']."</option>";
						}
						?>
					</select>
				</div>

				<div class="form-group">
				<label for="life_group_id">Life Group:</label>
					<select name="life_group_id" class="custom-select">						
						<?php
						echo '<option value="">None</option>';
						$LifeGroupIDStmt = $con->prepare("SELECT * FROM life_groups");
						$LifeGroupIDStmt->execute(array());
						while($LifeGroupRow = $LifeGroupIDStmt->fetch(PDO::FETCH_ASSOC)) {
							$isSelected = "";
							if($LifeGroupRow['LifeGroupID'] == $LifeGroupID){
								$isSelected = "selected";
							}
							echo "<option value=".$LifeGroupRow['LifeGroupID']." $isSelected>".$LifeGroupRow['LifeGroupName']."</option>";
						}
						?>
					</select>
				</div>

			  <div class="form-group">
				<label for="home_address">Home Address:</label>
				<input type="text" class="form-control" id="home_address" value="<?php echo $HomeAddress; ?>" placeholder="Enter home address" name="home_address" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $home_address_error; ?></span>
			  </div>

			  <div class="form-group">
				<label for="prayer_request">Prayer Request:</label>
				<input type="text" class="form-control" id="prayer_request" value="<?php echo $PrayerRequest; ?>" placeholder="Enter prayer request" name="prayer_request">
			  </div>

				<div class="form-group form-check">
					<label class="form-check-label"></label>
						<input class="form-check-input" type="checkbox" name="opt_text" <?php echo $opt_phone_checked; ?>>Opt in for text notifications
					</label>
				</div>

				<div class="form-group form-check">
					<label class="form-check-label"></label>
						<input class="form-check-input" type="checkbox" name="opt_email" <?php echo $opt_email_checked; ?>>Opt in for email notifications
					</label>
				</div>
				<span class="help-block"><?php echo $any_error; ?></span>
			  <button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</div>