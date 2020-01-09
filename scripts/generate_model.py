
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
        module["namespace"] = module["name"].capitalize()
    print("Successfully read JSON file.")
    return module


def write_model(module, charset):
    check_folders("./modules/generated/")
    filename = "./modules/generated/" + module["name"].capitalize() + "Model.php"
    print("Writing to %s..." % filename)
    with open(filename, "w", encoding=charset) as file:
        file.write("<?php\n\n" +
                   "namespace App\\" + module["namespace"].capitalize() + ";\n\n" +
                   "use App\\Core\\AbstractModel;\n\n" +
                   "class " + module["name"].capitalize() + "Model extends AbstractModel\n" +
                   "{\n")
        for value in module["properties"]:
            file.write(4 * " " + "public $" + value + ";\n")
        file.write("}\n")
    print("Finished writing %s." % filename)


def main():
    print("Enter JSON filename:")
    filename = "./modules/" + input("./modules/")

    if os.path.isfile(filename):
        module = parse_json(filename, "utf-8")
        write_model(module, "utf-8")
    else:
        print("Error: Couldn't read %s." % filename)

    print("All operations completed. Exiting...")
    sys.exit()


main()
