function retrieveData(formData) {
    let args = {};
    for (let [key, value] of formData.entries()) {
        args[key] = value;
    }
    return args;
}

export default retrieveData;