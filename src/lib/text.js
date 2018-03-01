export default class Text {
  capitalize(str) {
    str = str.toLowerCase()
    return str.charAt(0).toUpperCase() + str.substring(1)
  }
}
