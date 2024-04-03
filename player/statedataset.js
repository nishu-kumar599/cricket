

const statesData = [
    {
        name: "Andaman and Nicobar Islands",
        cities: ["Port Blair", "Car Nicobar", "Mayabunder", "Bombooflat"]
    },
    {
        name: "Andhra Pradesh",
        cities: [
            "Visakhapatnam", "Vijayawada", "Guntur", "Nellore", "Kurnool",
            "Rajahmundry", "Tirupati", "Kadapa", "Kakinada", "Anantapur",
            "Chittoor", "Kadapa", "Srikakulam", "Eluru", "Ongole", "Vizianagaram"
        ]
    },
    {
        name: "Arunachal Pradesh",
        cities: ["Itanagar", "Naharlagun", "Tawang", "Pasighat", "Ziro"]
    },
    {
        name: "Assam",
        cities: [
            "Guwahati", "Silchar", "Dibrugarh", "Jorhat", "Nagaon",
            "Tinsukia", "Tezpur", "Dhubri", "Sivasagar", "Golaghat",
            "Karimganj", "Hailakandi", "Bongaigaon", "Nalbari", "Diphu",
            "Barpeta", "Lanka"
        ]
    },
    {
        name: "Bihar",
        cities: [
            "Patna", "Gaya", "Bhagalpur", "Muzaffarpur", "Purnia",
            "Darbhanga", "Bihar Sharif", "Arrah", "Begusarai", "Katihar",
            "Munger", "Chhapra", "Danapur", "Saharsa", "Hajipur", "Gopalganj",
            "Siwan", "Motihari", "Nawada", "Bagaha"
        ]
    },
    {
        name: "Chandigarh",
        cities: ["Chandigarh"]
    },
    {
        name: "Chhattisgarh",
        cities: [
            "Raipur", "Bhilai", "Korba", "Bilaspur", "Durg",
            "Rajnandgaon", "Raigarh", "Jagdalpur", "Ambikapur", "Dhamtari"
        ]
    },
    {
        name: "Dadra and Nagar Haveli",
        cities: ["Silvassa"]
    },
    {
        name: "Daman and Diu",
        cities: ["Daman", "Diu"]
    },
    {
        name: "Delhi",
        cities: [
            "New Delhi", "Delhi", "Noida", "Ghaziabad", "Faridabad",
            "Gurgaon", "Meerut", "Panipat", "Sonipat", "Rohtak"
        ]
    },
    {
        name: "Goa",
        cities: ["Panaji", "Vasco da Gama", "Margao", "Mapusa"]
    },
    {
        name: "Gujarat",
        cities: [
            "Ahmedabad", "Surat", "Vadodara", "Rajkot", "Bhavnagar",
            "Jamnagar", "Junagadh", "Gandhinagar", "Nadiad", "Morbi",
            "Surendranagar", "Bharuch", "Anand", "Porbandar", "Godhra"
        ]
    },
    {
        name: "Haryana",
        cities: [
            "Faridabad", "Gurgaon", "Panipat", "Ambala", "Yamunanagar",
            "Rohtak", "Hisar", "Karnal", "Sonipat", "Panchkula",
            "Bhiwani", "Sirsa", "Bahadurgarh", "Jind", "Thanesar"
        ]
    },
    {
        name: "Himachal Pradesh",
        cities: [
            "Shimla", "Solan", "Dharamshala", "Palampur", "Hamirpur",
            "Una", "Mandi", "Kullu", "Bilaspur", "Nahan"
        ]
    },
    {
        name: "Jammu and Kashmir",
        cities: [
            "Srinagar", "Jammu", "Anantnag", "Baramulla", "Sopore",
            "Kathua", "Udhampur", "Rajouri", "Pulwama", "Kupwara",
            "Ramnagar", "Budgam", "Bandipora", "Ganderbal", "Ramban"
        ]
    },
    {
        name: "Jharkhand",
        cities: [
            "Ranchi", "Jamshedpur", "Dhanbad", "Bokaro Steel City", "Deoghar",
            "Phusro", "Hazaribagh", "Giridih", "Ramgarh", "Medininagar",
            "Chirkunda", "Jhumri Tilaiya", "Saunda", "Sahibganj", "Bokaro"
        ]
    },
    {
        name: "Karnataka",
        cities: [
            "Bangalore", "Hubli-Dharwad", "Mysore", "Gulbarga", "Mangalore",
            "Belgaum", "Davanagere", "Bellary", "Bijapur", "Shimoga",
            "Tumkur", "Raichur", "Bidar", "Hospet", "Hassan"
        ]
    },
    {
        name: "Kerala",
        cities: [
            "Thiruvananthapuram", "Kochi", "Kozhikode", "Kollam", "Thrissur",
            "Alappuzha", "Palakkad", "Malappuram", "Kannur", "Kottayam",
            "Manjeri", "Neyyattinkara", "Kasaragod", "Aluva", "Muvattupuzha"
        ]
    },
    {
        name: "Lakshadweep",
        cities: ["Kavaratti"]
    },
    {
        name: "Madhya Pradesh",
        cities: [
            "Indore", "Bhopal", "Jabalpur", "Gwalior", "Ujjain",
            "Sagar", "Dewas", "Satna", "Ratlam", "Rewa",
            "Singrauli", "Burhanpur", "Chhindwara", "Guna", "Shivpuri"
        ]
    },
    {
        name: "Maharashtra",
        cities: [
            "Mumbai", "Pune", "Nagpur", "Thane", "Pimpri-Chinchwad",
            "Nashik", "Kalyan-Dombivali", "Vasai-Virar", "Aurangabad", "Navi Mumbai",
            "Solapur", "Bhiwandi", "Amravati", "Nanded", "Kolhapur"
        ]
    },
    {
        name: "Manipur",
        cities: ["Imphal", "Thoubal", "Kakching", "Ukhrul", "Churachandpur"]
    },
    {
        name: "Meghalaya",
        cities: ["Shillong", "Tura", "Jowai", "Nongstoin", "Williamnagar"]
    },
    {
        name: "Mizoram",
        cities: ["Aizawl", "Lunglei", "Saiha", "Champhai", "Serchhip"]
    },
    {
        name: "Nagaland",
        cities: ["Kohima", "Dimapur", "Mokokchung", "Tuensang", "Wokha"]
    },
    {
        name: "Odisha",
        cities: [
            "Bhubaneswar", "Cuttack", "Rourkela", "Berhampur", "Sambalpur",
            "Puri", "Balasore", "Brahmapur", "Baripada", "Bhadrak",
            "Balangir", "Jharsuguda", "Bargarh", "Jeypore", "Rayagada"
        ]
    },
    {
        name: "Puducherry",
        cities: ["Puducherry", "Karaikal", "Yanam", "Mahe"]
    },
    {
        name: "Punjab",
        cities: [
            "Ludhiana", "Amritsar", "Jalandhar", "Patiala", "Bathinda",
            "Mohali", "Hoshiarpur", "Pathankot", "Moga", "Abohar",
            "Batala", "Muktasar", "Khanna", "Rajpura", "Firozpur"
        ]
    },
    {
        name: "Rajasthan",
        cities: [
            "Jaipur", "Jodhpur", "Kota", "Bikaner", "Ajmer",
            "Udaipur", "Bhilwara", "Alwar", "Bharatpur", "Sikar",
            "Pali", "Sri Ganganagar", "Barmer", "Hanumangarh", "Sawai Madhopur"
        ]
    },
    {
        name: "Sikkim",
        cities: ["Gangtok", "Namchi", "Mangan", "Gyalshing", "Singtam"]
    },
    {
        name: "Tamil Nadu",
        cities: [
            "Chennai", "Coimbatore", "Madurai", "Tiruchirappalli", "Salem",
            "Tirunelveli", "Tiruppur", "Kanyakumari", "Thanjavur", "Thoothukudi",
            "Vellore", "Kancheepuram", "Erode", "Tiruvannamalai", "Dindigul"
        ]
    },
    {
        name: "Telangana",
        cities: [
            "Hyderabad", "Warangal", "Nizamabad", "Khammam", "Karimnagar",
            "Ramagundam", "Mahbubnagar", "Nalgonda", "Adilabad", "Suryapet",
            "Miryalaguda", "Jagtial", "Nirmal", "Kamareddy", "Medak"
        ]
    },
    {
        name: "Tripura",
        cities: ["Agartala", "Udaipur", "Dharmanagar", "Belonia", "Kailashahar"]
    },
    {
        name: "Uttar Pradesh",
        cities: [
            "Agra", "Aligarh", "Allahabad", "Ambedkar Nagar", "Amethi (Chatrapati Sahuji Mahraj Nagar)", "Amroha (J.P. Nagar)", 
            "Auraiya", "Azamgarh", "Baghpat", "Bahraich", "Ballia", "Balrampur", "Banda", "Barabanki", "Bareilly", "Basti", 
            "Bhadohi", "Bijnor", "Budaun", "Bulandshahr", "Chandauli", "Chitrakoot", "Deoria", "Etah", "Etawah", "Faizabad", 
            "Farrukhabad", "Fatehpur", "Firozabad", "Gautam Buddha Nagar", "Ghaziabad", "Ghazipur", "Gonda", "Gorakhpur", 
            "Hamirpur", "Hapur (Panchsheel Nagar)", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi", "Kannauj", "Kanpur Dehat", 
            "Kanpur Nagar", "Kanshiram Nagar (Kasganj)", "Kaushambi", "Kushinagar (Padrauna)", "Lakhimpur - Kheri", "Lalitpur", 
            "Lucknow", "Maharajganj", "Mahoba", "Mainpuri", "Mathura", "Mau", "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", 
            "Pilibhit", "Pratapgarh", "RaeBareli", "Rampur", "Saharanpur", "Sambhal (Bhim Nagar)", "Sant Kabir Nagar", "Shahjahanpur", 
            "Shamali (Prabuddh Nagar)", "Shravasti", "Siddharth Nagar", "Sitapur", "Sonbhadra", "Sultanpur", "Unnao", "Varanasi"
        ]
    },
    
    {
        name: "Uttarakhand",
        cities: [
            "Dehradun", "Haridwar", "Roorkee", "Haldwani", "Rudrapur",
            "Kashipur", "Rishikesh", "Pauri", "Ramnagar", "Ranikhet",
            "Kotdwara", "Haldwani", "Tehri"
        ]
    },
    {
        name: "West Bengal",
        cities: [
            "Kolkata", "Asansol", "Siliguri", "Durgapur", "Bardhaman",
            "English Bazar", "Baharampur", "Habra", "Kharagpur", "Shantipur",
            "Dankuni", "Dhulian", "Bansberia", "Banganapalle"
        ]
    }
];


