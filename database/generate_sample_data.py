import uuid
import random

bevs = ["Corona", "Guinness", "Hop House", "Heineken", "Fosters", "Murphy's", "Blue Moon", "Hoegaarden", "Vodka", "Bacardi", "Rum", "Whiskey", "Gin", "Coors", "Carlsberg", "Stella"]
interests = ["Drinking", "Cars", "Reading", "Movies", "Pool", "Coding", "Fashion", "Stocks", "Oil", "Money", "Traveling", "Exercise", "Gym", "Phography", "Walking", "Sports", "Rugby", "Soccer", "GAA", "Music", "Bowling", "Surfing", "Gardening", "Art", "Hiking", "Swimming", "Parties"]
first_names = ["Tadhg", "Milan", "Breny", "Kevin", "Craig", "Simon", "Jacob", "Boris", "Amy", "Miriam", "Steve", "Martha", "Samantha", "Sophie", "Hans", "John", "Euan", "Eoghan", "Piotr", "Sean"]
second_names = ["Ryan", "Quinn", "Kovacs", "Hawk", "O'Reilly", "Boblicov", "Phayer", "McGrath", "Flynn", "Bourke", "O'Gorman", "Danys", "Murray", "Cahill", "Ryan", "McCarthy", "Walsh", "Collins"]
bios = ["Hello, I am a computer scientist and I go to UL. I have a 4.0QCA and my mother works for Intel so she gave me a internship there for my coop :D", "Hey, how you doing? ;)", "The sky is blue, the grass is green, is there anything more beautiful, than a few creams", "Ideally, we'd be drinking now", "How many cans of bulmers would last you a night? Wrong answers only", "How many drinks does it take me to get arsed to screw a lightbulb", "If you drink corona, you're the one for me", "Anyone for coffee instead??", "Guiness Yuuppp", "Bacardi Yuuuppp", "Corona Yuuppp", "Heinekein Yuuppp", "Hop House Yuuppp", "Fosters Yuuppp"]
user_ids = []

NUMBER_OF_USERS = 30

def fill_uuids():
    i = 0
    while (i<NUMBER_OF_USERS):
        user_ids.append(uuid.uuid4())
        i += 1

def write_bevs():
    return_string = ""
    for bev in bevs:
        return_string += f"INSERT INTO beverages (name) VALUES ('{bev}');\n"
    return return_string

def write_interests():
    return_string = ""
    for interest in interests:
        return_string += f"INSERT INTO Interests (name) VALUES ('{interest}');\n"
    return return_string

def write_users(id):
    birth_date = f"{random.randint(1969, 2005)}-{random.randint(1, 12)}-{random.randint(1, 28)}"
    first_name = random.choice(first_names)
    email_name = f"{first_name}{((int) (random.random() * 1000))}"
    return f"INSERT INTO Users (id, lastName, firstName, email, hashedPassword, dateOfBirth, dateJoined, admin, banned, reportcount) VALUES ('{id}', '{first_name}', '{random.choice(second_names)}', '{email_name}.test@example.com', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', '{birth_date}', '2024-01-01', FALSE, FALSE, 0);\n" 

def write_profiles(id):
    sex = random.random() > 0.5 if "Male" else "Female"
    seeking = random.random() > 0.5 if "Male" else "Female"
    bio = random.choice(bios)
    return f"INSERT INTO Profiles (userId, gender, seeking, description, likeCount, dislikeCount) VALUES('{id}', '{sex}', '{seeking}', '{bio}', 0, 0);\n"

def write_userInterests(id):
    i=0
    return_string = ""
    while i < random.randint(1, 5):
        return_string += f"INSERT INTO UserInterests (userid, interestid) VALUES('{id}', {random.randint(0, interests.__len__())});\n"
        i += 1
    return return_string

def write_userBev(id):
    return f"INSERT INTO UserBeverages (userid, beverageid) VALUES('{id}', {random.randint(0, bevs.__len__())});\n"

with open('output.txt', 'a') as f:
    fill_uuids()
    f.write(write_bevs())
    f.write("\n")
    f.write(write_interests())
    f.write("\n")
    f.write("\n")
    for id in user_ids:
        f.write(write_users(id))
        f.write(write_profiles(id))
        f.write(write_userInterests(id))
        f.write("\n")
