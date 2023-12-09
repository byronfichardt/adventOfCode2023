use std::fs;

fn main() {
    // Read the input file
    let input = fs::read_to_string("input.txt").expect("Failed to read input file");
    let lines = input.lines();
    let mut totals: Vec<i32> = Vec::new();
    lines.for_each(|line| {
        let mut numbers: Vec<i32> = line.split_whitespace().map(|x| x.parse::<i32>().unwrap()).collect();
        let mut number_set = vec![numbers.clone()];

        while let Some(new_numbers) = calculate_new_numbers(&numbers) {
            number_set.push(new_numbers.clone());
            numbers = new_numbers;
        }
        // create a new vector with the last element of each vector in number_set
        let result: Vec<i32> = number_set.iter().map(|x| x[x.len() - 1]).collect();
        
        let mut new_values = vec![0];
        result.iter().rev().cloned().collect::<Vec<_>>().windows(2).for_each(|window| {
            new_values.push(new_values.last().unwrap() + window[1]);
        });
        
        totals.push(new_values.last().unwrap().clone());
    });
    // print the sum of the totals
    println!("Total: {}", totals.iter().sum::<i32>());
}

fn calculate_new_numbers(numbers: &[i32]) -> Option<Vec<i32>> {
    // check if all values are zero
    let allZero = numbers.iter().all(|&x| x == 0);
    let sum = numbers.iter().sum::<i32>();

    if sum == 0 && allZero {
        None
    } else {
        let new_numbers: Vec<i32> = numbers.windows(2).map(|window| window[1] - window[0]).collect();
        Some(new_numbers)
    }
}
