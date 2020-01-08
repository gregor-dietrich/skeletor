
import os
import shutil
import sys

root = "."


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


def rewrite_file(filename, array, skip, charset):
    if input("Save credentials to %s? (y/n) " % filename) == "y":
        auth = {
                "dbhost": input("Hostname: "),
                "dbname": input("Database: "),
                "dbuser": input("Username: "),
                "dbpass": input("Password: ")
        }
        print("Writing credentials to %s." % filename)
        target_file = open(root + "/../app/src/System/%s" % filename, "w", encoding=charset)
        with open(root + "/setup/%sdefault.php" % filename[:-3], "r", encoding=charset) as source_file:
            for line in source_file:
                if array not in line or skip in line:
                    target_file.write(line)
                else:
                    for key, value in auth.items():
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

    rewrite_file("db.php", "$_ENV", "dbchar", "utf-8")

    print("All operations completed. Exiting...")
    sys.exit()


main()
