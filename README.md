
The purpose of this Repo is to save and track the micro projects that could prove helpful in the future


- Please put each micro project in a separate branch 
- Leave the Master branch empty expect for this readme file
- Update readme file with your project's branch and its description. 
 
To Checkout only the branch you need, please follow the following steps 

```bash
mkdir working_dir && cd working_dir
git init .                            #initialize empty repo
git checkout -b tanseeq               # switch to a local branch with the same name to avoid confusion, not necessary though
git remote add origin  git@github.com:espace/misc.git 
git pull origin tanseeq
```

# misc
Misc Micro projects 

- Branch alternative contains code/data to crawl the website http://alternativeto.net/ for FOSS products.
- Branch tanseeq contains code for a simple gadget that is used to query college tanseeq results along with a script to format the data in a csv form.
- Branch **1M.Site** contains web-technologies crawler that gets the technologies (Rails/PHP/..) a certain website is using, given the CSV file containing the websites. It supports both HTTP/HTTPS. 
