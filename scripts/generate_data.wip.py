
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


def write_sql(module, query, charset):
    check_folders("./modules/generated/")
    filename = "./modules/generated/" + module + ".sql"
    print("Writing to %s..." % filename)
    with open(filename, "w", encoding=charset) as file:
        file.write(query + "\n")
        print("Finished writing %s." % filename)


def main():
    modules = ["user_groups", "users", "user_groups_meta", "post_categories", "posts", "post_comments"]
    queries = []

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
            group_types = ["Corporation", "Association", "Team", "Group", "Syndicate", "Squad", "Partnership"]
            query += "(\"" + random_string(random.randint(3, 10)).capitalize()
            if random.randint(0, 1) == 1:
                query += " " + random_string(random.randint(3, 10)).capitalize()
            query += " " + group_types[random.randint(0, len(group_types) - 1)]
            query += "\")"
        elif module == "users":
            query += "(\"" + random_string(random.randint(3, 12)).capitalize() + "\",\""\
                     + random_string(60, mode="hash") + "\",\""\
                     + random_string(20, mode="alphanumeric").lower() + "\",\"1\",\"" + random_email()\
                     + "\",\"1\",\"::1\",\""\
                     + "2019-" + random_date(1, 12) + "-" + random_date(1, 28) + " " + random_date(0, 23)\
                     + ":" + random_date(0, 59) + ":" + random_date(0, 59) + "\",\""\
                     + "2020-01-" + random_date(1, 31) + " " + random_date(0, 23)\
                     + ":" + random_date(0, 59) + ":" + random_date(0, 59) + "\")"
        elif module == "user_groups_meta":
            query += ""
        elif module == "post_categories":
            query += ""
        elif module == "posts":
            query += ""
        elif module == "post_comments":
            query += ""
        query += ";"

        queries.append(query)
        # write_sql(module, query, "utf-8")

    print("All operations completed. Exiting...")
    sys.exit()


main()
