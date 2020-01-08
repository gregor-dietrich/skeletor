# pip install mysql-connector-python
import mysql.connector
import os
import shutil
import sys

root = "."


def init_db():
    sql_file = os.path.join(root + "/setup/app.sql")

    if os.path.isfile(sql_file):
        auth = {
            "dbhost": input("Hostname: "),
            "dbname": input("Database: "),
            "dbuser": input("Username: "),
            "dbpass": input("Password: ")
        }

        try:
            print("Connecting to database...")
            connection = mysql.connector.connect(
                user=auth["dbuser"],
                password=auth["dbpass"],
                host=auth["dbhost"],
                database=auth["dbname"])
            if connection.is_connected():
                print("Connected to database '%s'!" % auth["dbname"])
                cursor = connection.cursor()

                rewrite_file("db.php", auth, "$_ENV", "dbchar", "utf-8")

                if input("Drop database tables (if they exist)? (y/n) ") == "y":
                    print("Dropping database tables...")
                    cursor.execute("DROP TABLE IF EXISTS `post_comments`, `posts`, `post_categories`;")
                    cursor.execute("DROP TABLE IF EXISTS `users`, `user_ranks`;")
                    print("Database tables dropped.")
                else:
                    print("Not dropping existing tables (if any).")

                if input("Create database tables? (y/n) ") == "y":
                    print("Creating database tables...")
                    parse_sql(sql_file, cursor, ";", "utf-8")
                else:
                    print("Database initialization skipped.")

        except mysql.connector.Error as e:
            if "Query was empty" not in str(e):
                print("Database connection error: ", e)
            else:
                print("Finished parsing %s." % sql_file)

        finally:
            if "connection" in locals():
                if connection.is_connected():
                    print("Closing database connection...")
                    cursor.close()
                    connection.close()
                    print("Connection closed.")

    else:
        print("Error: " + root + "/setup/app.sql not found.")


def init_files():
    files = {
        "db.php": "../app/src/System/",
        "salt.php": "../app/src/System/"
    }

    for filename, subdir in files.items():
        sub_dirs = subdir.split("/")
        make_dir = sub_dirs[0] + "/"
        for dir_name in sub_dirs[1:]:
            make_dir += dir_name + "/"
            if not os.path.exists(os.path.join(root, make_dir)):
                os.mkdir(os.path.join(root, make_dir))

        target = os.path.join(root,  subdir, filename)
        if not os.path.isfile(target):
            print("Couldn't find " + filename + ". Creating...")
            src = os.path.join(root + "/setup/" + filename[:-3] + "default.php")
            if os.path.isfile(src):
                shutil.copyfile(src, target)
                print("Success.")
            else:
                print("Error: " + root + "/setup/" + filename[:-3] + "default.php not found.")
        else:
            print(filename + " already exists. Skipping...")


def parse_sql(filename, cursor, delimiter, charset):
    file = open(filename, "r", encoding=charset)
    contents = file.read()
    file.close()
    queries = contents.split(delimiter)
    for query in queries:
        cursor.execute(query)


def rewrite_file(filename, data, array, skip, charset):
    if input("Save credentials to %s? (y/n) " % filename) == "y":
        print("Writing credentials to %s." % filename)
        target_file = open(root + "/../app/src/System/%s" % filename, "w", encoding=charset)
        with open(root + "/setup/%sdefault.php" % filename[:-3], "r", encoding=charset) as source_file:
            for line in source_file:
                if array not in line or skip in line:
                    target_file.write(line)
                else:
                    for key, value in data.items():
                        if key in line:
                            target_file.write(array + "['" + key + "'] = '" + value + "';\n")
        target_file.close()
        print("Finished writing to %s." % filename)
    else:
        print("Skipped writing to %s." % filename)


def main():
    if input("Create default files? (y/n) ") == "y":
        init_files()
    else:
        print("Default file creation skipped.")

    if input("Establish MySQL connection? (y/n) ") == "y":
        init_db()
    else:
        print("MySQL connection skipped.")

    print("All operations completed. Exiting...")
    sys.exit()


main()
