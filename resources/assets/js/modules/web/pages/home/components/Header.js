import React from "react"

const displayName = "HomePageHeader"

function Header() {
    return <header className="bg-primary text-white">
        <div className="container text-center">
            <h1>Rapide</h1>
        </div>
    </header>
}

Header.displayName = displayName

export default Header
