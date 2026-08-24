type AppLogoProps = {
    header?: string;
}

export default function AppLogo({ header }: AppLogoProps) {
    return (
        <>
            <div className="flex aspect-square size-8 items-center justify-center overflow-hidden rounded-md">
                <img src="/school-logo.jpeg" alt="Carmen National High School" className="size-8 rounded-md object-cover" />
            </div>
            <div className="ml-1 grid flex-1 text-left text-sm">
                <span className="mb-0.5 truncate leading-tight font-semibold">{header || "BookLib Admin Panel v0.1"}</span>
            </div>
        </>
    );
}
