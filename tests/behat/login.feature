Feature: Search
  In order to see a wolfpack content
  As a website user
  I need to be logged in

  @javascript
  Scenario: Logging in with an invalid email
    Given I am on "/"
     When I follow "Login"
      And I fill in "email" with "wrong@email.com"
      And I fill in "password" with "ems12345@"
      And I press "Login"
     Then I should see "The selected email is invalid."

  @javascript
  Scenario: Logging in with an invalid password
    Given I am on "/"
     When I follow "Login"
      And I fill in "email" with "webteam@teamarmando.com"
      And I fill in "password" with "wrong password"
      And I press "Login"
     Then I should see "Sorry, you do not have permission to login."

  @javascript
  Scenario: Logging in with an invalid email and password
    Given I am on "/"
     When I follow "Login"
      And I fill in "email" with "wrong@email.com"
      And I fill in "password" with "wrong password"
      And I press "Login"
     Then I should see "The selected email is invalid."

  @javascript
  Scenario: Logging in with an valid credentials
    Given I am on "/"
     When I follow "Login"
      And I fill in "email" with "webteam@teamarmando.com"
      And I fill in "password" with "ems@12345"
      And I press "Login"
     Then I should not see "The selected email is invalid."
      And I should see "You are logged in!"
