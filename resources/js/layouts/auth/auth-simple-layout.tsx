import { Card, CardContent } from '@/components/ui/card';
import { Link } from '@inertiajs/react';
import { type PropsWithChildren } from 'react';

interface AuthLayoutProps {
    name?: string;
    title?: string;
    description?: string;
}

export default function AuthSimpleLayout({ children, title, description }: PropsWithChildren<AuthLayoutProps>) {
    return (
        <div className="flex min-h-svh flex-col items-center justify-center gap-6 bg-[#f2ede2] p-6 md:p-10">
            <div className="w-full max-w-sm">
                <Card className="w-full">
                    <CardContent className="flex flex-col gap-8 px-8">
                        <div className="flex flex-col items-center gap-4">
                            <Link href={route('login')} className="flex flex-col items-center gap-3 font-medium">
                                <div className="flex h-28 w-28 items-center justify-center rounded-full">
                                    <img src="/school-logo.jpeg" alt="Carmen National High School" className="h-28 w-28 rounded-full object-cover" />
                                </div>
                                <span className="text-center font-serif text-2xl font-bold text-[#1a2a5e] dark:text-white">
                                    Carmen National High School
                                </span>
                            </Link>

                            {title && (
                                <div className="space-y-2 text-center">
                                    <h1 className="text-xl font-medium">{title}</h1>
                                    {description && <p className="text-center text-sm text-muted-foreground">{description}</p>}
                                </div>
                            )}
                        </div>
                        {children}
                    </CardContent>
                </Card>
            </div>
        </div>
    );
}
