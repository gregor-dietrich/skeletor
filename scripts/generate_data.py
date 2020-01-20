
import os
import random
import sys
import string


def check_folders(subdir):
    sub_dirs = subdir.split("/")
    make_dir = sub_dirs[0] + "/"
    for dir_name in sub_dirs[1:]:
        make_dir += dir_name + "/"
        if not os.path.exists(os.path.join(make_dir)):
            os.mkdir(os.path.join(make_dir))


def get_input(table):
    user_input = int(input("Insert how many rows into table %s? " % table))
    if user_input < 0:
        user_input = abs(user_input)
    return user_input


def lorem_ipsum(paragraphs):
    lipsum_1 = "Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
    lipsum_2 = "Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat."
    lipsum_3 = "Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi."
    lipsum_4 = "Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat."
    lipsums = [lipsum_1.split(". "), lipsum_2.split(". "), lipsum_3.split(". "), lipsum_4.split(". ")]
    text = ""
    for i in range(int(paragraphs)):
        paragraph = []
        for lipsum in lipsums:
            paragraph.append(lipsum[random.randint(0, len(lipsum) - 1)])
        paragraph = ". ".join(paragraph)
        paragraph = paragraph.replace("..", ".")
        text += paragraph
        if i != int(paragraphs) - 1:
            text += "\n\n"
    return text


def random_string(length, mode="letters"):
    result = ""
    alphabet = string.ascii_letters
    if mode == "alphanumeric":
        numbers = [str(i) for i in range(1, 11)]
        alphabet += "".join(numbers)
    elif mode == "hash":
        result += "$2y$10$"
        length -= 7
        alphabet += "/."
    elif mode == "hex":
        del alphabet
        alphabet = [str(i) for i in range(0, 10)]
        alphabet = "".join(alphabet)
        alphabet += "abcdef"

    random.shuffle(alphabet.split())
    for i in range(length):
        result += alphabet[random.randint(0, len(alphabet)-1)]
    return str(result)


def random_email():
    tld = ["at", "biz", "ch", "com", "co.uk", "de", "edu", "eu", "gov", "io", "net", "onion", "nl", "org", "tv", "xyz"]
    email = random_string(random.randint(3, 10))
    if random.randint(0, 1) == 1:
        email += "." + random_string(random.randint(4, 10), mode="alphanumeric")
    email += "@" + random_string(random.randint(3, 10))
    email += "." + tld[random.randint(0, len(tld)-1)]
    return email.lower()


def random_date(min_val, max_val):
    result = random.randint(min_val, max_val)
    if result < 0:
        return "ERROR NaN"
    elif 0 <= result < 10:
        return "0" + str(result)
    else:
        return str(result)


def write_sql(queries, charset):
    check_folders("./modules/generated/")
    filename = "./modules/generated/data.sql"
    print("Writing to %s..." % filename)
    with open(filename, "w", encoding=charset) as file:
        for query in queries:
            file.write(query + "\n")
        print("Finished writing %s." % filename)


def main():
    modules = ["user_groups", "users", "user_groups_meta", "post_categories", "posts", "post_comments"]
    queries = []
    user_groups = 0
    users = 0
    post_categories = 0
    posts = 0

    for module in modules:
        query = "INSERT INTO `" + module + "` ("
        if module == "user_groups":
            query += "`name`"
        elif module == "users":
            query += "`username`,`password`,`salt`,`rank_id`,`email`,`activated`,`last_ip`,`created`,`last_login`"
        elif module == "user_groups_meta":
            query += "`user_id`,`group_id`,`timestamp`"
        elif module == "post_categories":
            query += "`name`,`parent_id`"
        elif module == "posts":
            query += "`title`,`content`,`user_id`,`category_id`,`published`,`commentable`,`created`,`last_edit`"
        elif module == "post_comments":
            query += "`content`,`post_id`,`user_id`,`created`"

        query += ") VALUES "

        if module == "user_groups":
            user_groups = get_input("user_groups")
            group_types = ["Corporation", "Association", "Team", "Group", "Syndicate", "Squad", "Partnership"]
            for i in range(user_groups):
                query += "(\"" + random_string(random.randint(3, 10)).capitalize()
                if random.randint(0, 1) == 1:
                    query += " " + random_string(random.randint(3, 10)).capitalize()
                query += " " + group_types[random.randint(0, len(group_types) - 1)]
                query += "\")"
                if i != user_groups - 1:
                    query += ","
        elif module == "users":
            users = get_input("users")
            for i in range(users):
                query += "(\"" + random_string(random.randint(3, 12)).capitalize() + "\",\""\
                         + random_string(60, mode="hash") + "\",\""\
                         + random_string(20, mode="hex").lower() + "\",1,\"" + random_email()\
                         + "\",1,\"::1\",\""\
                         + "2019-" + random_date(1, 12) + "-" + random_date(1, 28) + " " + random_date(0, 23)\
                         + ":" + random_date(0, 59) + ":" + random_date(0, 59) + "\",\""\
                         + "2020-01-" + random_date(20, 31) + " " + random_date(0, 23)\
                         + ":" + random_date(0, 59) + ":" + random_date(0, 59) + "\")"
                if i != users - 1:
                    query += ","
        elif module == "user_groups_meta":
            user_groups_meta = get_input("user_groups_meta")
            pairs = []
            while len(pairs) < user_groups_meta:
                user_id, group_id = str(random.randint(2, users+1)), str(random.randint(1, user_groups))
                pair = user_id + "," + group_id
                if pair not in pairs:
                    pairs.append(pair)
                    query += "("
                    query += user_id + "," + group_id + ",\""
                    query += "2020-01-" + random_date(1, 19) + " " + random_date(0, 23)\
                             + ":" + random_date(0, 59) + ":" + random_date(0, 59) + "\")"
                    if len(pairs) != user_groups_meta:
                        query += ","
        elif module == "post_categories":
            post_categories = get_input("post_categories")
            parents = ["General", "Other", "Technology", "Programming", "Webdesign", "Science", "Politics", "Economy"]
            for i in range(post_categories):
                if i < len(parents):
                    query += "(\"" + parents[i] + "\",NULL"
                else:
                    if i == len(parents):
                        query += ";\n" + "INSERT INTO `" + module + "` (`name`,`parent_id`) VALUES "
                    query += "(\""
                    query += random_string(random.randint(3, 9)).capitalize()
                    for j in range(random.randint(1, 3)):
                        query += " " + random_string(random.randint(2, 12)).capitalize()
                    query += "\"," + str(random.randint(1, len(parents)))
                query += ")"
                if i != post_categories - 1 and i != len(parents) - 1:
                    query += ","
        elif module == "posts":
            posts = get_input("posts")
            for i in range(posts):
                query += "(\""
                query += random_string(random.randint(3, 9)).capitalize()
                for j in range(random.randint(2, 4)):
                    query += " " + random_string(random.randint(2, 12)).capitalize()
                query += "\",\"" + lorem_ipsum(random.randint(3, 6)) + "\","
                user_id, category_id = str(random.randint(2, users+1)), str(random.randint(1, post_categories))
                query += "%s,%s,1,1,\"" % (user_id, category_id)
                query += "2020-01-" + random_date(1, 14) + " " + random_date(0, 23)\
                         + ":" + random_date(0, 59) + ":" + random_date(0, 59) + "\",\""
                query += "2020-01-" + random_date(15, 19) + " " + random_date(0, 23)\
                         + ":" + random_date(0, 59) + ":" + random_date(0, 59) + "\")"
                if i != posts - 1:
                    query += ","
        elif module == "post_comments":
            post_comments = get_input("post_comments")
            for i in range(post_comments):
                query += "(\"" + lorem_ipsum(random.randint(1, 2)) + "\","
                query += str(random.randint(1, posts)) + "," + str(random.randint(2, users+1))
                query += ",\"" + "2020-01-" + random_date(15, 19) + " " + random_date(0, 23)\
                         + ":" + random_date(0, 59) + ":" + random_date(0, 59) + "\")"
                if i != post_comments - 1:
                    query += ","
        query += ";"
        queries.append(query)
    write_sql(queries, "utf-8")

    print("All operations completed. Exiting...")
    sys.exit()


main()
