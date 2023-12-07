fn main() {
    let input = std::fs::read_to_string("input.txt").unwrap();
    let mut totalpoints = 0;
    for line in input.lines() {
        
        let cards = line.split('|').collect::<Vec<&str>>();
        println!("Cards: {:?}", cards);
        let card1 = cards[0].split(':').collect::<Vec<&str>>()[1];
        let card2 = cards[1];
        // get the numbers from card 1 
        let nums1 = card1.split(' ').collect::<Vec<&str>>();
        // get the numbers from card 2
        let nums2 = card2.split(' ').collect::<Vec<&str>>();
        // filter out possible empty strings
        let nums1 = nums1.iter().filter(|&x| !x.is_empty()).collect::<Vec<&&str>>();
        let nums2 = nums2.iter().filter(|&x| !x.is_empty()).collect::<Vec<&&str>>();
        // convert the numbers to i32
        let nums1 = nums1.iter().map(|&x| x.parse::<i32>().unwrap()).collect::<Vec<i32>>();
        let nums2 = nums2.iter().map(|&x| x.parse::<i32>().unwrap()).collect::<Vec<i32>>();
        println!("Nums: {:?}", nums1);
        println!("Nums: {:?}", nums2);

        let mut points = 0;
        let mut count = 1;
        for num in nums2 {
            if nums1.contains(&num) {
                if count == 1 {
                    points += 1;
                } else {
                    points += points;
                }
                count += 1;
            }
        } 
        totalpoints += points;
        
    }
    println!("Points: {}", totalpoints);
}
