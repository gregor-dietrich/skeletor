
import json
import os
import sys


def check_folders(subdir):
    sub_dirs = subdir.split("/")
    make_dir = sub_dirs[0] + "/"
    for dir_name in sub_dirs[1:]:
        make_dir += dir_name + "/"
        if not os.path.exists(os.path.join(make_dir)):
            os.mkdir(os.path.join(make_dir))


def parse_json(filename, charset):
    print("%s found! Reading contents..." % filename)
    with open(filename, "r", encoding=charset) as file:
        data = file.read()
    module = json.loads(data)

    for k, v in module.items():
        if k in ["name", "plural", "namespace"]:
            module[k] = v.capitalize()

    if module["namespace"] == "":
        module["namespace"] = module["name"]
    print("Successfully read JSON file.")
    return module


def write_controller(module, charset):
    check_folders("./modules/generated/")
    filename = "./modules/generated/" + module["plural"] + "Controller.php"
    print("Writing to %s..." % filename)
    with open(filename, "w", encoding=charset) as file:
        indent = 4 * " "
    # TO DO
    print("Finished writing %s." % filename)


def main():
    print("Enter JSON filename:")
    filename = "./modules/" + input("./modules/")

    if os.path.isfile(filename):
        module = parse_json(filename, "utf-8")
        write_controller(module, "utf-8")
    else:
        print("Error: Couldn't read %s." % filename)

    print("All operations completed. Exiting...")
    sys.exit()


main()
