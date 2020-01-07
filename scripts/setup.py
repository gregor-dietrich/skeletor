
import mysql.connector
import os
import shutil
import sys

root = os.path.dirname(__file__)


def init_db():
    sql_file = os.path.join(root + "/setup/app.sql")

    if os.path.isfile(sql_file):
        auth = {
            "db_host": input("Hostname: "),
            "db_name": input("Database: "),
            "db_user": input("Username: "),
            "db_pass": input("Password: ")
        }

        try:
            print("Connecting to database...")
            connection = mysql.connector.connect(
                user=auth["db_user"],
                password=auth["db_pass"],
                host=auth["db_host"],
                database=auth["db_name"])
            if connection.is_connected():
                print("Connected to database '%s'!" % auth["db_name"])
                cursor = connection.cursor()

                write_auth = input("Save credentials to db.php? (y/n) ")
                if write_auth == "y":
                    print("Writing credentials to db.php...")
                    # TO DO
                    print("Finished writing to db.php.")
                else:
                    print("Skipped writing to db.php.")

                drop_tables = input("Drop database tables (if they exist)? (y/n) ")
                if drop_tables == "y":
                    print("Dropping database tables...")
                    cursor.execute("DROP TABLE IF EXISTS `post_comments`, `posts`, `post_categories`;")
                    cursor.execute("DROP TABLE IF EXISTS `users`, `user_ranks`;")
                    print("Database tables dropped.")
                else:
                    print("Not dropping existing tables (if any).")

                create_tables = input("Create database tables? (y/n) ")
                if create_tables == "y":
                    print("Creating database tables...")
                    parse_sql(sql_file, cursor)
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


def parse_sql(sql_file, cursor):
    file = open(sql_file, "r", encoding="utf-8")
    contents = file.read()
    file.close()
    commands = contents.split(";")
    for command in commands:
        cursor.execute(command)


def main():
    create_files = input("Create default files? (y/n) ")
    if create_files == "y":
        init_files()
    else:
        print("Default file creation skipped.")

    create_connection = input("Create MySQL connection? (y/n) ")
    if create_connection == "y":
        init_db()
    else:
        print("MySQL connection skipped.")

    print("All operations completed. Exiting...")
    sys.exit()


main()
