
The purpose of this Repo is to save and track the micro projects that could prove helpful in the future


1. Please put each micro project in a separate branch 
2. Leave the Master branch empty expect for this readme file
3. Update readme file with your project's branch and its description. 
 
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

- Branch [**alternative**](https://github.com/espace/misc/tree/alternative) contains code/data to crawl the website http://alternativeto.net/ for FOSS products.

- Branch [**tanseeq**](https://github.com/espace/misc/tree/tanseeq) contains code for a simple gadget that is used to query college tanseeq results along with a script to format the data in a csv form.

- Branch [**1M.Site**](https://github.com/espace/misc/tree/1M.Site) contains web-technologies crawler that gets the technologies (Rails/PHP/..) a certain website is using, given the CSV file containing the websites. It supports both HTTP/HTTPS. 

- Branch [**Item_Based_Recommendation_System**](https://github.com/espace/misc/tree/Item_Based_Recommendation_System), develops a recommendation system for items based on processing Apache Access logs 

- [**altitude**](https://github.com/espace/misc/tree/altitude) , Provides a display of your altitude respect to nearest area. 

- [**tenders-scraping**](https://github.com/espace/misc/tree/tenders-scraping) , scraps tenders post on supported sites and sends email alert
- [**traffic-timelapse**](https://github.com/espace/misc/tree/traffic-timelapse), creates an animated Traffic Time lapse 

- [**web-tech**](https://github.com/espace/misc/tree/web-tech) Views the data generated by the [**1M.Site**](https://github.com/espace/misc/tree/1M.Site)
